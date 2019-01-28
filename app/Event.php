<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_name', 'interest_id', 'event_desc', 'event_location', 'event_datetime', 'event_pts'
    ];

    public function interest(){
        return $this->belongsTo('App\Interest', 'interest_id');
    }

    public function going(){
        return $this->hasMany('App\Going', 'event_id');
    }
}
