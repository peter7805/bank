<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Accounts extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    /**
     * 指定是否模型應該被戳記時間。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 驗證登入資料。
     */
    public function loginData($account, $userId, $password)
    {

        $login_time = date("Y-m-d H:i:s", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y')));
        $sqlData = $this->where('account', $account)->first();
        if (!empty($sqlData)) {
            $ck_userId = $sqlData->userId;
            $ck_password = $sqlData->password;
            $login_failed = $sqlData->login_failed;
            if ($login_failed == 3) {
                return '密碼錯誤3次，已凍結帳號，請聯繫客服人員';
            } else {
                if ($userId != $ck_userId) {
                    return '使用者代碼輸入錯誤';
                } elseif (!password_verify($password, $ck_password)) {
                    $login_failed++;
                    $this->where('account', $account)->update(array('login_failed' => $login_failed, 'login_time' => $login_time));
                    return '密碼輸入錯誤' . $login_failed . '次，3次即凍結帳戶';
                } else {
                    $login_failed = 0;
                    $this->where('account', $account)->update(array('login_failed' => $login_failed, 'login_time' => $login_time));
                    // $newData = $this->where('account', $account)->first();
                    return true;
                }
            }
        } else {
            return '查無此帳號';
        }
    }

    /**
     * 驗證註冊資料。
     */
    public function signupData($name, $account, $userId, $password, $balance = 0, $login_failed = 0)
    {
        $sqlData = $this->where('account', $account)->first();
        if (empty($sqlData)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $this->insert(array(
                'name' => $name,
                'account' => $account,
                'userId' => $userId,
                'password' => $password,
                'balance' => $balance,
                'login_failed' => $login_failed,
            ));
            return true;
        } else {
            return '此帳號已被使用，請使用其他帳號';
        }
    }
}
