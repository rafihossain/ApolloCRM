<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingDocumentType extends Model
{
    use HasFactory;
    protected $table = "document_types";

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
