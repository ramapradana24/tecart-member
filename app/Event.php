<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';

    public function interest(){
        return $this->belongsTo('App\Interest', 'interest_id');
    }
}
