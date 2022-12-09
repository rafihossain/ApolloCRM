<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKpiTarget extends Model
{
    use HasFactory;
    protected $table = "user_kpi_target";
    protected $fillable = ['id','user_id','kpi_heading','kpi_perameter','kpi_frequency','date_form','date_to','target_currency','target_value'];
}
