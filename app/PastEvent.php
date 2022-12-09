<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
class PastEvent extends Model
{
    public $timestamps = false;

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }
}
