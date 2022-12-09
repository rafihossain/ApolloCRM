<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    public function PartnerBranch()
    {
        return $this->belongsTo(PartnerBranch::class, 'branch_id', 'id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }

    public function partnerBranches()
    {
        return $this->belongsTo(PartnerBranch::class, 'branch_id', 'id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type', 'id');
    }
}
