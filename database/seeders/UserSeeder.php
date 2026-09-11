<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('name', 'admin')->firstOrFail();
        $kasir = Role::where('name', 'kasir')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role_id' => $admin->id,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@example.com'],
            [
                'name' => 'Kasir',
                'password' => Hash::make('password'),
                'role_id' => $kasir->id,
                'email_verified_at' => now(),
            ]
        );

        User::factory()->count(3)->create([
            'role_id' => $kasir->id,
        ]);
    }
}
