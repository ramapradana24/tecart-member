<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id';

    public function interest(){
        return $this->belongsTo('App\Interest', 'interest_id');
    }
}
