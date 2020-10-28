<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountInfo extends Model
{
    use HasFactory;
    protected $table = 'accountInfo';
    public $timestamps = false;

    public function insertData($user_id, $number, $amount, $money, $balance, $calculate, $remark = "")
    {
        $sqlData = $this->where('number', $number)->first();
        if (empty($sqlData)) {
            $this->insert(array(
                'user_id' => $user_id,
                'number' => $number,
                'amount' => $amount,
                'money' => $money,
                'balance' => $balance,
                'calculate' => $calculate,
                'remark' => $remark,
            ));
            DB::table('accounts')->where('id', $user_id)->update(array('balance' => $balance));
            return true;
        } else {
            return false;
        }
    }
}
