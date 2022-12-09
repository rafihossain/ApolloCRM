<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $table = "partners";

    public function workflow()
    {
        return $this->belongsTo(WorkflowCategory::class, 'workflow_id', 'id');
    }
    public function masterCategory()
    {
        return $this->belongsTo(MasterCategory::class, 'master_category_id', 'id');
    }
    public function partnerType()
    {
        return $this->belongsTo(PartnerType::class, 'partner_type', 'id');
    }
    public function product()
    {
        return $this->hasMany(Product::class, 'partner_id', 'id');
    }
    public function branch()
    {
        return $this->hasMany(PartnerBranch::class, 'partner_id', 'id');
    }
}
