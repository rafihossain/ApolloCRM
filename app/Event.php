<?php

namespace App;
use App\AwardsPrize;
use App\Location;
use App\EventDate;
use App\EventLocation;
use App\EventTime;
use App\EventWeekDay;
use App\PastEvent;
use App\WeekendWinner;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;
    
    public function awards(){
        return $this->hasMany(AwardsPrize::class);
    }

    public function location(){
        return $this->hasOne(Location::class,'event_id');
    }

    public function event_time(){
        return $this->hasOne(EventTime::class);
    }

    public function event_location(){
        return $this->hasOne(EventLocation::class);
    }

    public function event_date(){
        return $this->hasOne(EventDate::class);
    }

    public function event_week_day(){
        return $this->hasOne(EventWeekDay::class);
    }

    public function past_event(){
        return $this->hasOne(PastEvent::class);
    }
	
	public function weekend_winners(){
		return $this->hasMany(WeekendWinner::class);
	}
}
