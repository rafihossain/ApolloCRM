<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Feetype extends Model
{
    use HasFactory;
    protected $table = "fee_types";

    // public function masterCategory(){
    //     return $this->belongsTo(MasterCategory::class, 'master_category_id', 'id');
    // }
   
}
