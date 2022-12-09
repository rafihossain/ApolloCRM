<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentModel extends Model
{
    use HasFactory;
    protected $table = "agents";

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}
