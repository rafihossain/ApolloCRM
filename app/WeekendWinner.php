<?php

namespace App;
use App\Athlete;
use App\Event;

use Illuminate\Database\Eloquent\Model;

class WeekendWinner extends Model
{
    public $timestamps = false;
	
	public function athlete(){
	 return $this->belongsTo(Athlete::class,'athlete_id');
	}
	
	public function event(){
	 return $this->belongsTo(Event::class,'event_id');
	}
}
