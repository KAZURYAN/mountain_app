<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = array('id');

    public $timestamps = false;

    //CSVヘッダーを指定
    protected $fillable = ['membership_date','name','kana_name','email','age','sex','car_status','address','holiday','plan_stance','job','member_status'];
}
