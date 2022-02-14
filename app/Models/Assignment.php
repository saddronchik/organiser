<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'author_id');
    }

    public function addressed(): BelongsTo
    {
        return $this->belongsTo(User::class,'addressed_id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_id');
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class,'executor_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function statuses(): BelongsTo
    {
        return $this->belongsTo(Status::class,'status_id');
    }

}
