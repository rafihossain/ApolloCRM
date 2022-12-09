<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerAppointment extends Model
{
    use HasFactory;
    protected $table = "appointments";
    
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
