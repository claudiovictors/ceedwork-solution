<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (blank($email) || blank($password)) {
            $this->command?->warn(
                'Administrador não criado: defina ADMIN_EMAIL e ADMIN_PASSWORD no ficheiro .env.'
            );

            return;
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrador Ceedwork'),
                'password' => Hash::make($password),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        if (! $user->isAdmin()) {
            $user->forceFill(['is_admin' => true])->save();
        }

        $this->command?->info("Administrador garantido: {$user->email}");
    }
}
