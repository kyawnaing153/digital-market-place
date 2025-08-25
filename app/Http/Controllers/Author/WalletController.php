<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Wallet};
use Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $Obj = new Wallet();
        $data['data'] =  $Obj->filter()->where('user_id',$user->id)->orderBy('id','DESC')->paginate(10);

        $data['total_amount'] = $Obj->where('user_id',$user->id)->select(\DB::raw('SUM(credit - debit) as total'))->value('total');
        $data['withdraw_amount'] = $Obj->where(['user_id'=>$user->id,'status'=>1])->sum('debit');
    
        $data['searchable'] =  Wallet::$searchable;
        return view('author.wallet.index',$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Wallet::find($id);
        if(empty($data)){
            return redirect()->route('vendor.wallet.index');
        }

        $data['data'] = $data;
        return view('author.wallet.show',$data);
    }

      /**
     * Store a withdraw request.
     */

    public function store(request $request){
        $rules['amount'] = 'required|numeric';
        $userId =  auth()->id();

        $total_amount = Wallet::where('user_id',$userId)->select(\DB::raw('SUM(credit - debit) as total'))->value('total');
        if($request->amount > $total_amount){
            return response()->json(['status' => false,'msg' => trans('msg.insufficient_balance') ], 400);
        }

        if($request->amount < (int) getSetting()->min_withdraw){
            return response()->json(['status' => false,'msg' => trans('msg.greater_min_withdrawal') ], 400);
        }
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);  

            $obj = new Wallet();
            $obj->user_id = $userId;
            $obj->type = 'WITHDRAW';
            $obj->debit = $request->amount;
            $obj->save();

            return response()->json(['status' => true,'msg' => trans('msg.withdraw_req_suc')], 200);
    }
}
