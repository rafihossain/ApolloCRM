<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentChecklist extends Model
{
    use HasFactory;
    protected $table = "document_checklist";

    public function workflow()
    {
        return $this->belongsTo(WorkflowCategory::class, 'workflow_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function total_checklist()
    {
        return $this->hasMany(DocumentTotalChecklist::class, 'checklist_id', 'id');
    }
    
}
