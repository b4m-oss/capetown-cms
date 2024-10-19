<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $fillable = [
        'name',
        'label',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

        // 日付属性を指定
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
