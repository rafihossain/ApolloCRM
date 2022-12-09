<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automation extends Model
{
    use HasFactory;
    protected $table = "automations";

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

}
