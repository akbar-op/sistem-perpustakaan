<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use LogicException;

class InitialAdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'admin')->exists()) {
            throw new LogicException('An Admin already exists; refusing to create another bootstrap account.');
        }

        $credentials = config('admin.bootstrap');

        foreach (['name', 'email', 'password'] as $key) {
            if (blank($credentials[$key] ?? null)) {
                throw new LogicException("Set INITIAL_ADMIN_{$key} in the environment before running this seeder.");
            }
        }

        $validated = Validator::make($credentials, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:16', 'max:255'],
        ])->validate();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        $this->command?->info('Initial Admin account created. The password was not displayed.');
    }
}