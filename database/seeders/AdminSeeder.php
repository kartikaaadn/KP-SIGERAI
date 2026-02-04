<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin MPP',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'gerai_id' => null,
                'is_active' => true,
            ]
        );
    }
}
