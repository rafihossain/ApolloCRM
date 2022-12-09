<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingWorkflow extends Model
{
    use HasFactory;
    protected $table = "setting_workflow";

    public function stage(){
        return $this->hasMany(WorkflowStage::class, 'setting_workflow_id', 'id');
    }
}
