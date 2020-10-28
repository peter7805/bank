<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    /**
     * 會員登入驗證
     */
    public function login(Request $request, Accounts $accounts)
    {
        $account = $request->account;
        $userId = $request->userId;
        $password = $request->password;

        $result = $accounts->loginData($account, $userId, $password);
        echo $result;
        exit;
        return ($result);
    }

    /**
     * 會員註冊驗證
     */
    public function signup(Request $request, Accounts $accounts)
    {
        $name = $request->name;
        $account = $request->account;
        $userId = $request->userId;
        $password = $request->password;

        $result = $accounts->signupData($name, $account, $userId, $password);
        return ($result);
    }

    /**
     * 會員登出
     */
    public function signout()
    {
    }
}
