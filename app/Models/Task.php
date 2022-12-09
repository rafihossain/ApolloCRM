<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = "tasks";
    
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'contact_id', 'id');
    }
    public function application()
    {
        return $this->belongsTo(Application::class, 'contact_id', 'id');
    }
    public function taskCategory()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id', 'id');
    }
    public function assign()
    {
        return $this->belongsTo(User::class, 'assigee_id', 'id');
    }
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }
}
