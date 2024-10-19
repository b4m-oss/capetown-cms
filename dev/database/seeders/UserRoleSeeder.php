<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserStatus::create([
            [
                'name' => 'administrator',
                'label' => 'administrator'
            ],
            [
                'name' => 'editor',
                'label' => 'editor'
            ],
            [
                'name' => 'author',
                'label' => 'author'
            ],
            [
                'name' => 'contributor',
                'label' => 'subscriber'
            ],
        ]);
    }
}
