<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

#[Signature('admin:reset-password {email : Email address of the Admin account}')]
#[Description('Securely reset an Admin account password')]
class ResetAdminPassword extends Command
{
    public function handle(): int
    {
        $admin = User::query()
            ->where('email', $this->argument('email'))
            ->where('role', 'admin')
            ->first();

        if (! $admin) {
            $this->error('No Admin account found for that email.');

            return self::FAILURE;
        }

        $password = $this->secret('New password (minimum 16 characters)');

        if (! is_string($password) || mb_strlen($password) < 16) {
            $this->error('Password must contain at least 16 characters.');

            return self::FAILURE;
        }

        $confirmation = $this->secret('Confirm new password');

        if (! is_string($confirmation) || ! hash_equals($password, $confirmation)) {
            $this->error('Password confirmation does not match.');

            return self::FAILURE;
        }

        $admin->forceFill(['password' => Hash::make($password)])->save();

        $this->info('Admin password updated.');

        return self::SUCCESS;
    }
}
