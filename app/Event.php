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

    public function tags(){
        return $this->belongsToMany('App\Tag','event_tags')
        ->withTimestamps();
    }

    public function members(){
        return $this->belongsToMany('App\Member','event_members')
        ->withTimestamps();
    }
}
