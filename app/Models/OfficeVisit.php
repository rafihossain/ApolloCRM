<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeVisit extends Model
{
    use HasFactory;
    protected $table = "office_visites";

    public function client()
    {
        return $this->belongsTo(Client::class, 'contact_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'assigne_id', 'id');
    }
}
