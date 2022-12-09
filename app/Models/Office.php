<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $table = "offices";
    
    public function all_country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

}
