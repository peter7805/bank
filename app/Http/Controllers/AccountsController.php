<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupPost;
use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Session;


class AccountsController extends Controller
{
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

    /**
     * 會員登入驗證
     */
    public function login(Request $request, Accounts $accounts)
    {
        $account = $request->account;
        $userId = $request->userId;
        $password = $request->password;
        $login_time = date("Y-m-d H:i:s");
        $sqlData = $accounts->selectData($account);
        if (!empty($sqlData)) {
            $ck_userId = $sqlData->userId;
            $ck_password = $sqlData->password;
            $login_failed = $sqlData->login_failed;
            if ($login_failed == 3) {
                return array('result' => false, 'msg' => '密碼錯誤3次，已鎖定帳號，請聯繫客服人員');
            } else {
                if ($userId != $ck_userId) {
                    return array('result' => false, 'msg' => '使用者代碼輸入錯誤');
                } elseif (!password_verify($password, $ck_password)) {
                    $login_failed++;
                    $accounts->loginFaile($account, $login_failed, $login_time);
                    return array('result' => false, 'msg' => '密碼輸入錯誤' . $login_failed . '次，3次即鎖定帳號');
                } else {
                    $login_failed = 0;
                    $accounts->loginFaile($account, $login_failed, $login_time);
                    $newData = $accounts->selectData($account);
                    Session::put('id', $newData['id']);
                    return array('result' => true);;
                }
            }
        } else {
            return ['result' => false, 'msg' => '查無此帳號'];
        }
    }

    /**
     * 會員註冊驗證
     */
    public function signup(SignupPost $request, Accounts $accounts)
    {
        $name = $request->name;
        $account = $request->account;
        $userId = $request->userId;
        $password = $request->password;
        $password = password_hash($password, PASSWORD_DEFAULT);

        $result = $accounts->signupData($name, $account, $userId, $password);
        return ($result);
    }

    /**
     * 會員登出
     */
    public function signout()
    {
        Session::flush();
        return redirect('/bank');
    }
}
