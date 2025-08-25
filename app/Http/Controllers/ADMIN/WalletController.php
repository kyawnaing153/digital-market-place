<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Wallet,Setting,UserAdditionalInfo};

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Obj = new Wallet();
        $data['data'] =  $Obj->filter()->orderBy('id','DESC')->paginate(10);
        $data['total_amount'] = $Obj->sum(\DB::raw('credit', '-', 'debit'));
        $data['searchable'] =  Wallet::$searchable;
        return view('admin.wallet.index',$data);
    }

    /**
     * Display a listing of the resource.
     */
    public function withdraw_request()
    {
        $Obj = new Wallet();
        $data['data'] =  $Obj->filter()->where('type','WITHDRAW')->orderBy('id','DESC')->paginate(10);
        $data['searchable'] =  Wallet::$searchable;
        return view('admin.wallet.withdraw_request',$data);
    }

     /**
     * Display a listing of the resource.
     */
    public function withdraw_setting()
    {
        $data['data'] = (object)Setting::pluck('short_value','key')->toArray();
        return view('admin.wallet.withdraw_setting',$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Wallet::find($id);
        if(empty($data)){
            return redirect()->route('admin.wallet.index');
        }
        return view('admin.wallet.show',compact('data'));
    }


    /**
     * Display the specified resource.
     */
    public function  edit_request(string $id)
    {
        $data = Wallet::find($id);
        if(empty($data)){
            return redirect()->route('admin.wallet.withdraw-request');
        }
        $data['user_details'] = (object) UserAdditionalInfo::where('user_id',$data->user_id)->pluck('value','key')->toArray();
        $data['data'] = $data;

        return view('admin.wallet.edit_request',$data);
    }

    public function  update_request(request $request)
    {
        $data = Wallet::find($request->id);
        if(empty($data)){
            return redirect()->route('admin.wallet.withdraw-request');
        }
        $data->status = $request->status;
        $data->note = $request->note;
        $data->save();

        return response()->json(['status' => true,'msg' =>"Withdraw request updated successfully.",'url'=>route('admin.wallet.withdraw-request')], 200);

    }
   

}
