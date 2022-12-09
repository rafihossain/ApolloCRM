<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = "quotations";
    
    public function quotation_product()
    {
        return $this->hasMany(Quotationitem::class, 'quotation_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_user', 'id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class, 'office', 'id');
    }
}
