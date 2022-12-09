<?php

namespace App;
use App\WeekendWinner;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    public $timestamps = false;
	
	public function winners(){
		return $this->hasMany(WeekendWinners::class);
	}
}
