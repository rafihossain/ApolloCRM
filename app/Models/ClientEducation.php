<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEducation extends Model
{
    use HasFactory;
    protected $table = "client_educations";

    public function degreelevel()
    {
        return $this->belongsTo(DegreeLevel::class, 'degree_level', 'id');
    }
    public function subjectarea()
    {
        return $this->belongsTo(SubjectArea::class, 'subject_area', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

}
