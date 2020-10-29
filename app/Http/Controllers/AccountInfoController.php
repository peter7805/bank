<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountInfo;
use App\Models\Accounts;
use Illuminate\Support\Facades\DB;

class AccountInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = 1;
        // $balance = session('balance');
        $balance = DB::table('accounts')->where('id', $id)->value('balance');

        return view('homepage', ['money' => $balance]);
    }

    public function deposit_page()
    {
        $id = 1;
        // $balance = session('balance');
        $balance = DB::table('accounts')->where('id', $id)->value('balance');

        return view('deposit', ['money' => $balance]);
    }

    public function withdrawal_page()
    {
        $id = 1;
        // $balance = session('balance');
        $balance = DB::table('accounts')->where('id', $id)->value('balance');

        return view('withdrawal', ['money' => $balance]);
    }
    #存款
    public function deposit(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        $number = date("YmdHis", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y'))) . rand(1000, 9999);
        $amount = intval($request->amount);
        $money = intval($request->money);
        $balance = $amount + $money;
        $type = 0;
        $remark = $request->remark;

        $result = $accountInfo->insertData($user_id, $number, $amount, $money, $balance, $type, $remark);
        return $result;
    }
    #提款
    public function withdrawal(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        $number = date("YmdHis", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y'))) . rand(100, 999);
        $amount = intval($request->amount);
        $money = intval($request->money);
        $balance = $amount - $money;
        $type = 1;
        $remark = $request->remark;

        $result = $accountInfo->insertData($user_id, $number, $amount, $money, $balance, $type, $remark);
        return $result;
    }
    #搜尋紀錄
    public function search(Request $request, AccountInfo $accountInfo)
    {
    }
}
