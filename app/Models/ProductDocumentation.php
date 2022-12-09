<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductDocumentation extends Model
{
    use HasFactory;
    protected $table = "product_documentations";

    public function alluser(){
        return $this->belongsTo(User::class, 'author', 'id');
    }
   
}
