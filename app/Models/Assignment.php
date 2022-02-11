<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'preamble',
        'text',
        'author_id',
        'addressed_id',
        'assigned_id',
        'executor_id',
        'department_id',
        'status_id',
        'deadline',
        'real_deadline'
    ];
}
