<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
      'from_date' => 'required',
      'to_date' => 'required',
      'planner' => 'required',
      'content' => 'required',
    );

    public function user(){
      return $this->belongsTo('App\User');
  }
}
