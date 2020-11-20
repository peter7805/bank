<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountInfo;
use App\Models\Accounts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AccountInfoController extends Controller
{

    public function __construct()
    {
        #需要登入才能使用此class
        $this->middleware('userAuth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Accounts $accounts)
    {
        if (Session::has('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
            return view('bank.homepage', ['id' => $data['id'], 'name' => $data['name'], 'balance' => $data['balance']]);
        } else {
            return view('bank.login');
        }
    }

    public function deposit_page(Accounts $accounts)
    {
        if (Session::has('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
            return view('bank.deposit', ['id' => $data['id'], 'name' => $data['name'], 'balance' => $data['balance']]);
        } else {
            return view('bank.login');
        }
    }

    public function withdrawal_page(Accounts $accounts)
    {
        if (Session::has('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
            return view('bank.withdrawal', ['id' => $data['id'], 'name' => $data['name'], 'balance' => $data['balance']]);
        } else {
            return view('bank.login');
        }
    }
    #紀錄
    public function show(Request $request, AccountInfo $accountInfo, Accounts $accounts)
    {
        if (Session::has('id')) {
            $id = Session::get('id');
            $data = $accounts->selectData($id);
        }
        $user_id = session('id');
        $start_time = date("Y-m-d H:i:s", strtotime($request->start_time));
        $end_time = date("Y-m-d H:i:s", (strtotime($request->end_time) + 86399));
        if (strtotime($start_time) > strtotime($end_time)) {
            return view('bank.homepage', ['errormsg' => '開始日期不得大於結束日期']);
        }
        $searchData = $accountInfo->searchData($user_id, $start_time, $end_time);
        return view('bank.homepage', ['searchData' => $searchData, 'name' => $data['name'], 'balance' => $data['balance']]);
    }
    #存款
    public function deposit(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        DB::beginTransaction();
        try {
            DB::table('accounts')->where('id', $user_id)->lockForUpdate()->get();
            $txt = $accountInfo->searchLastData($user_id);
            if (empty($txt)) {
                $txt = 1;
            } else {
                $txt++;
            }
            $new_txt = str_pad($txt, 5, "0", STR_PAD_LEFT);
            $number = date("YmdHis", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y'))) . $new_txt;
            $amount = DB::table('accounts')->where('id', $user_id)->value('balance');
            $money = intval($request->money);
            $balance = $amount + $money;
            $type = '存款';
            $remark = $request->remark;
            $result = $accountInfo->insertData($user_id, $number, $amount, $money, $balance, $type, $remark);
            echo $result;
            DB::commit();
        } catch (\Exception $e) {
            $e->getMessage();
            DB::rollBack();
            return false;
        }
    }
    #提款
    public function withdrawal(Request $request, AccountInfo $accountInfo)
    {
        $user_id = $request->user_id;
        DB::beginTransaction();
        try {
            DB::table('accounts')->where('id', $user_id)->lockForUpdate()->get();
            $txt = $accountInfo->searchLastData($user_id);
            if (empty($txt)) {
                $txt = 1;
            } else {
                $txt++;
            }
            $new_txt = str_pad($txt, 5, "0", STR_PAD_LEFT);
            $number = date("YmdHis", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y'))) . $new_txt;
            $amount = DB::table('accounts')->where('id', $user_id)->value('balance');
            $money = intval($request->money);
            $balance = $amount - $money;
            $type = '提款';
            $remark = $request->remark;
            $result = $accountInfo->insertData($user_id, $number, $amount, $money, $balance, $type, $remark);
            echo $result;
            DB::commit();
        } catch (\Exception $e) {
            return false;
            $e->getMessage();
            DB::rollBack();
        }
    }
}
