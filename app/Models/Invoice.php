<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "invoices";

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
}
