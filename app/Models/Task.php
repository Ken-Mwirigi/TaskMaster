<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    // This line tells Laravel it is okay to save these specific fields 
    // into the database during a POST request.
    use HasFactory; // Add this line inside the class
    protected $fillable = ['title', 'due_date', 'priority', 'status'];
}