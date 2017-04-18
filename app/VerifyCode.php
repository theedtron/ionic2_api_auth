<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyCode extends Model
{
    //
    protected $table = "verify_codes";

    protected $fillable = ['user_id','code'];
}
