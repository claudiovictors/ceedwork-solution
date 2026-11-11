<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 'TEST_USER_PASSWORD';

        User::updateOrCreate(
            ['email' => 'barrosclaudio147@gmail.com'],
            [
                'name' => 'CeedWork',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $this->command?->info('Utilizador de teste garantido: barrosclaudio147@gmail.com');
    }
}
