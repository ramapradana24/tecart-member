<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Going extends Model
{
    protected $table = 'going';
    protected $primaryKey = 'going_id';

    public function event(){
        return $this->belongsTo('App\Event', 'event_id');
    }
}
