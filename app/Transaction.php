<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transactions';

    protected $fillable = [
        'phone',
        'client_name',
        'transaction_id',
        'amount',
        'account_no',
        'transaction_time'
    ];

    public static function logTransaction($data){
        $log =Transaction::create($data);

        return $log;
    }

    public static function fetchTransactions(){
        $trans = Transaction::all();

        return $trans;
    }
}
