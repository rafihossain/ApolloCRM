<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table = "brand";
    protected $fillable = ['id','brand_name','status','brand_image'];

    // public function getStream(){
    //     return $this->belongsTo(Stream::class, 'stream_id', 'id');
    // }

    // public function getAgeGroup(){
    //     return $this->belongsTo(AgeGroup::class, 'ageGroup_id', 'id');
    // }
}
