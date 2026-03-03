<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'shuvo@wardtech.co.uk'],
            [
                'name'     => 'Shahadat Shuvo',
                'password' => Hash::make('password'),
                'role'     => UserRole::Admin,
            ]
        );
    }
}
