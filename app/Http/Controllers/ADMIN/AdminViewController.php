<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,ProductAnalysis,Order,OrderProduct};
use App\Models\Frontend\Contactus;
use App\Models\Admin\{DiscountCoupon,Product};
use Auth;
use App\Charts\DashboardChart;
use Carbon\Carbon;
class AdminViewController extends Controller
{

    //admin login page
    public function login_view()
    {
        return view('admin.login');
    }
    
    //admin dashboard page
    public function dashboard_view(Request $reqeust)
    {
        $userObj = new User();
        /* for getting total active and deactive user */
        $data['active_user']= $userObj->where('role','!=',0)->where('is_active',1)->count(); //Role 0 is Admin 
        $data['deactive_user']= $userObj->where('role','!=',0)->where('is_active',0)->count();
        $data['total_user']= $userObj->where('role','!=',0)->count();
        $data['total_vendor']= $userObj->where('role',2)->count();
        
        $product = new Product();
        /* for getting total active and deactive product */
        $data['active_product'] = $product->where('is_active',1)->count();
        $data['product_free'] = $product->where('is_free',1)->count();

        $ProductAnalysisQuery = ProductAnalysis::query();
        $ProductAnalysis = new ProductAnalysis();
        $user = User::query();
        $OrderProduct = OrderProduct::query();
        $Order = Order::query();

         /* search filter query */
        if($reqeust->date){  //filter
            $ProductAnalysisQuery->whereDate('created_at',$reqeust->date);
            $user->whereDate('created_at',$reqeust->date);
            $OrderProduct->whereDate('created_at',$reqeust->date);
            $Order->whereDate('created_at',$reqeust->date);
        }
        elseif(!empty($reqeust->start_date) && !empty($reqeust->end_date))
        {
            $ProductAnalysisQuery->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
            $user->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
            $OrderProduct->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
            $Order->whereBetween('created_at',[$reqeust->start_date,$reqeust->end_date]);
        }

         /* for getting total product veiw and product sales */
        $data['total_product_view'] = $ProductAnalysisQuery->count();
        $data['total_user_search']= $user->where('role','!=',0)->count();
        $data['total_product_sale']= $OrderProduct->count();

        $billing_total = $Order->sum('billing_total');
        $vendor_amount =  $OrderProduct->sum('vendor_amount');

        $data['total_product_sale_amount']=  $billing_total;
        $data['total_admin_revenue'] = ($billing_total - $vendor_amount);
        

        $mobile = $ProductAnalysis->where('device','Mobile')->count();
        $desktop = $ProductAnalysis->where('device','Desktop')->count();

       /*  pie chart for product view device */
        $productViewDevice = new DashboardChart;
        $productViewDevice->labels(['Mobile', 'Desktop']);
        $productViewDevice->dataset('Product View', 'pie', [$mobile, $desktop])
        ->backgroundColor(collect(['#00A0D0','#FFA524']))
        ->color(collect(['#00A0D0','#FFA524']));
        $data['productViewDevice'] = $productViewDevice; 

         /*  pie chart for product view broswer */
        $browser = $ProductAnalysis->get();
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

       /*  bar chart for user registratoin */
        $userdataValue = $userObj->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('M'); // grouping by months
        });

        $dateArray =[];
        $datevalueArr =[];
        foreach ($userdataValue as $key => $value) {
            $dateArray[] = $key;
            $datevalueArr[] = $value->count();
        }

        
        $userRegistrationViewChart = new DashboardChart;
        $userRegistrationViewChart->labels($dateArray);
        $userRegistrationViewChart->dataset('User', 'bar',   $datevalueArr)
        ->color("rgb(0, 128, 255)")
        ->backgroundcolor("rgb(0, 128, 255)");
        $data['userRegistrationViewChart'] = $userRegistrationViewChart;

        /*  bar chart for order sale */
        $totalsale = Order::orderBy('created_at','ASC')->get()
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
        return view('admin.single.dashboard', $data);
    }

    //Vendor dashboard page
    public function vendor_dashboard_view(Request $reqeust)
    {
    
        $product = new Product();
        /* for getting total active and deactive product */
        $data['active_product'] = $product->where('is_active',1)->count();
        $data['product_free'] = $product->where('is_free',1)->count();

        $ProductAnalysisQuery = ProductAnalysis::query();
        $ProductAnalysis = new ProductAnalysis();
        $OrderProduct = OrderProduct::query();
        $Order = Order::query();

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
        $data['total_product_view'] = $ProductAnalysisQuery->count();
        $data['total_product_sale']= $OrderProduct->count();
        $data['total_product_sale_amount']=  $Order->sum('billing_total');

        $mobile = $ProductAnalysis->where('device','Mobile')->count();
        $desktop = $ProductAnalysis->where('device','Desktop')->count();

       /*  pie chart for product view device */
        $productViewDevice = new DashboardChart;
        $productViewDevice->labels(['Mobile', 'Desktop']);
        $productViewDevice->dataset('Product View', 'pie', [$mobile, $desktop])
        ->backgroundColor(collect(['#00A0D0','#FFA524']))
        ->color(collect(['#00A0D0','#FFA524']));
        $data['productViewDevice'] = $productViewDevice; 

         /*  pie chart for product view broswer */
        $browser = $ProductAnalysis->get();
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
        $totalsale = Order::orderBy('created_at','ASC')->get()
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
        return view('admin.single.vendor_dashboard', $data);
    }

    //Admin My Profie Page view
    public function profile_view()
    {
        $data['data'] = Auth::user();
        return view('admin.single.profile', $data);
    }

    //Admin contactus view 
    public function contactus_view()
    {
        $data['data'] = \DB::table('contactus')->paginate(10);
        return view('admin.single.contactus', $data);
    }

       /**
   * Deleted the specified resource.
      */
  
    public function destroy(string $id){

        $data = Contactus::find($id);;
        if(empty($data)){
            return redirect()->route('admin.single.contactus');
        }
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.user_del')], 200);       
    }
}
