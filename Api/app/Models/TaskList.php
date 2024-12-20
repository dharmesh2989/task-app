<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['name', 'user_id', 'completed'];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the Task model
    public function tasks()
    {
        return $this->hasMany(Task::class); // A task list can have many tasks
    }
}
