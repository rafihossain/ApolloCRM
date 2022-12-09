<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerContact extends Model
{
    use HasFactory;
    protected $table = "partner_contacts";

    public function branch(){
        return $this->belongsTo(PartnerBranch::class, 'branch_id', 'id');
    }
}
