<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductPrice extends Model
{
    use HasFactory;
    protected $table = "product_prices";

    // public function masterCategory(){
    //     return $this->belongsTo(MasterCategory::class, 'master_category_id', 'id');
    // }
   
}
