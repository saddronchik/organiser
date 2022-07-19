<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package App\Models
 *
 * @mixin Builder
 * @property int $id;
 * @property string $title;
 */
class Department extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    public $timestamps = false;

    public static function new($title)
    {
        return static::create([
            'title' => $title
        ]);
    }
}
