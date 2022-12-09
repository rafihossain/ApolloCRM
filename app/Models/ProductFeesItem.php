<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductFeesItem extends Model
{
    use HasFactory;
    protected $table = "product_fees_items";

    public function fleestype(){
        return $this->belongsTo(Feetype::class, 'fee_type_id', 'id');
    }
   
}
