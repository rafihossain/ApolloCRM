<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = "applications";
    
    public function workflow()
    {
        return $this->belongsTo(WorkflowCategory::class, 'workflow_id', 'id');
    }
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(PartnerBranch::class, 'partner_id', 'id');
    }
    public function branch_office()
    {
        return $this->hasOne(PartnerBranch::class, 'partner_id', 'partner_id');
    }
    public function product_price()
    {
        return $this->hasOne(ProductPrice::class, 'product_id', 'product_id');
    }
}
