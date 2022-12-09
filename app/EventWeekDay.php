<?php

namespace App;
use App\Event;
use Illuminate\Database\Eloquent\Model;

class EventWeekDay extends Model
{
    public $timestamps = false;

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }
}