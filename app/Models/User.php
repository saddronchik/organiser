<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $fillable = ['full_name'];

    public static function new($fullName)
    {
        return static::create([
            'full_name' => $fullName
        ]);
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(Assignment::class);
    }


}
