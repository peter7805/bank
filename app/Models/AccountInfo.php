<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountInfo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'accountInfo';
    protected $fillable = ['user_id', 'number', 'amount', 'money', 'balance', 'type', 'remark'];

    public function insertData($user_id, $number, $amount, $money, $balance, $type, $remark = "")
    {
        $sqlData = $this->where('number', $number)->first();
        if (empty($sqlData)) {
            $this->insert(array(
                'user_id' => $user_id,
                'number' => $number,
                'amount' => $amount,
                'money' => $money,
                'balance' => $balance,
                'type' => $type,
                'remark' => $remark,
            ));
            DB::table('accounts')->where('id', $user_id)->update(array('balance' => $balance));
            return true;
        } else {
            return false;
        }
    }

    public function searchData($user_id, $start_time, $end_time)
    {
        $sqlData = $this->where('user_id', $user_id)->whereBetween('created_at', [$start_time, $end_time])->orderBy('id', 'desc')->paginate(10);

        return $sqlData;
    }

    public function searchLastData($user_id)
    {
        $sqlData = $this->where('user_id', $user_id)->orderBy('id', 'desc')->latest()->value('id');
        return $sqlData;
    }
}
