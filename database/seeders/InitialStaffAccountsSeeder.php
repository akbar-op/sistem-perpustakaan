<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use LogicException;

class InitialStaffAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $credentials = config('admin.staff_bootstrap');
        foreach (['role', 'name', 'email', 'password'] as $field) {
            if (blank($credentials[$field] ?? null)) {
                throw new LogicException("Set INITIAL_STAFF_{$field} in the environment before running this seeder.");
            }
        }

        $validated = Validator::make($credentials, [
            'role' => ['required', 'in:petugas,kepala_sekolah'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ])->validate();

        if (User::query()->where('role', $validated['role'])->exists()) {
            throw new LogicException("A {$validated['role']} account already exists; refusing to create a duplicate bootstrap account.");
        }

        DB::transaction(function () use ($validated): void {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);
        });

        $this->command?->info("Initial {$validated['role']} account created. The password was not displayed.");
    }
}