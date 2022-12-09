<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTotalChecklist extends Model
{
    use HasFactory;
    protected $table = "document_total_checklist";

    public function document()
    {
        return $this->belongsTo(SettingDocumentType::class, 'document_type_id', 'id');
    }
}
