<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['title', 'description', 'completed', 'task_list_id'];

    // Define the relationship with the TaskList model
    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }
}
