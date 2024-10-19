<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\CrudTrait;

class UserRepository
{
    use CrudTrait;

    protected $modelClass = User::class;

    // ここで必要に応じて追加のメソッドを実装できます
}
