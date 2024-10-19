<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'user_status';

    // 変更可能な属性を指定
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
