<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = "clients";

    public function product_info()
    {
        return $this->belongsTo(Product::class, 'application', 'id');
    }
    public function user_info()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }
    public function tag_info()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function flowers()
    {
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function pass_country()
    {
        return $this->belongsTo(Country::class, 'country_passport', 'id');
    }
}
