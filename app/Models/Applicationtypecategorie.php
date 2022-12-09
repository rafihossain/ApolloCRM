<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicationtypecategorie extends Model
{
    use HasFactory;
    protected $table = "application_type_categories";
    
     public function application_option()
    {
        return $this->hasMany(Applicationoption::class, 'category_id', 'id');
    }
}
