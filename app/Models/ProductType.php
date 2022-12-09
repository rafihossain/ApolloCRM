<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $table = "product_types";

    public function masterCategory(){
        return $this->belongsTo(MasterCategory::class, 'master_category_id', 'id');
    }

}
