<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerBranch extends Model
{
    use HasFactory;
    protected $table = "partner_branches";

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
