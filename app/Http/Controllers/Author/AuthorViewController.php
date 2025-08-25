<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,ProductAnalysis,Order,OrderProduct,UserAdditionalInfo,Wallet};
use App\Models\Admin\{DiscountCoupon,Product};
use Auth;
use App\Charts\DashboardChart;
use Carbon\Carbon;
class AuthorViewController extends Controller
{

    //Author login page
    public function login_view()
    {
        return view('author.login');
    }

    //Author dashboard page
    public function dashboard_view(Request $reqeust)
    {
        $user = auth()->user();
        $product = new Product();
        /* for getting total active and deactive product */
        $data['active_product'] = $product->where('user_id',$user->id)->where('is_active',1)->count();
        $data['product_free'] = $product->where('user_id',$user->id)->where('is_free',1)->count();

        $ProductAnalysisQuery = ProductAnalysis::query();

        $ProductAnalysis = new ProductAnalysis();

        $OrderProduct = OrderProduct::query();

        $OrderProduct->where('vendor_id',$user->id);

        $Order = OrderProduct::query();

         /* search filter query */
        if($reqeust->date){  //filter
            $ProductAnalysisQuery->whereDate('created_at',$reqeust->date);
            $OrderProduct->whereDate('created_at',$reqeust->date);
            $Order->whereDate('created_at',$reqeust->date);
        }
        elseif(!empty($reqeust->start_date) && !empty($reqeust->end_date))
        {
            $ProductAnalysisQuery->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
            $OrderProduct->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
            $Order->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
        }

         /* for getting total product veiw and product sales */
        $data['total_product_view'] = $ProductAnalysisQuery->where('user_id',$user->id)->count();
        $data['total_product_sale']= $OrderProduct->count();
        $data['total_product_sale_amount']=  $Order->where('vendor_id',$user->id)->sum('vendor_amount');
        $wallet = new Wallet();
        $data['available_balance'] = $wallet->where('user_id',$user->id)->select(\DB::raw('SUM(credit - debit) as total'))->value('total');
        $data['withdraw_amount'] = $wallet->where(['user_id'=>$user->id,'status'=>1])->sum('debit');
    
        $mobile = $ProductAnalysis->where('user_id',$user->id)->where('device','Mobile')->count();
        $desktop = $ProductAnalysis->where('user_id',$user->id)->where('device','Desktop')->count();

       /*  pie chart for product view device */
        $productViewDevice = new DashboardChart;
        $productViewDevice->labels(['Mobile', 'Desktop']);
        $productViewDevice->dataset('Product View', 'pie', [$mobile, $desktop])
        ->backgroundColor(collect(['#00A0D0','#FFA524']))
        ->color(collect(['#00A0D0','#FFA524']));
        $data['productViewDevice'] = $productViewDevice; 

        /*  pie chart for product view broswer */
        $browser = $ProductAnalysis->where('user_id',$user->id)->get();
        $browserValue = $browser->groupBy('browser');
        $browserArray =[];
        $valueArr =[];
        foreach ($browserValue as $key => $value) {
            $browserArray[] = $key;
            $valueArr[] = $value->count();
        }
        $productViewChart = new DashboardChart;
        $productViewChart->labels($browserArray);
        $productViewChart->dataset('Product View', 'pie',  $valueArr)
        ->backgroundColor(collect(['#9F48A6','#00B4B1','#3ae374', '#ff3838']))
        ->color(collect(['#9F48A6','#00B4B1','#32ff7e', '#ff4d4d']));
        $data['productViewChart'] = $productViewChart;

        /*  bar chart for order sale */
        $totalsale = OrderProduct::where('vendor_id',$user->id)->orderBy('created_at','ASC')->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('M'); // grouping by months
        });

        $saleArray =[];
        $salevalueArr =[];
        foreach ($totalsale as $key => $value) {
            $saleArray[] = $key;
            $salevalueArr[] = $value->count();
        }
        $saleViewChart = new DashboardChart;
        $saleViewChart->labels($saleArray);
        $saleViewChart->dataset('Total Sale', 'line',   $salevalueArr)
        ->color("rgb(255, 99, 132)")
        ->backgroundcolor("rgb(255, 99, 132)");

        $data['saleViewChart'] = $saleViewChart;
        return view('author.single.dashboard', $data);
    }

    //Author My Profie Page view
    public function profile_view()
    {
        $user = Auth::user();
        $data['data'] = $user;
        $data['additional_data'] = (object)UserAdditionalInfo::where('user_id',$user->id)->pluck('value','key')->toArray();
        return view('author.single.profile', $data);
    }
}
