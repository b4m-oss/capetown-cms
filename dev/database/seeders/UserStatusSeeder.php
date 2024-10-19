<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserStatus::create(['name' => 'active']);   // アクティブなユーザー
        UserStatus::create(['name' => 'inactive']); // 非アクティブなユーザー
        UserStatus::create(['name' => 'registered']); // 登録したユーザー
        UserStatus::create(['name' => 'suspended']); // 一時停止中のユーザー
        UserStatus::create(['name' => 'invited']); // 招待されたユーザー
    }
}
