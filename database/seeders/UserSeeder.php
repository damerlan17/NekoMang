<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew([
            'email' => 'admin@nekomang.test',
        ]);

        if (!$admin->exists) {
            $admin->name = 'Admin';
            $admin->password = Hash::make('Admin12345!');
        }

        $admin->role_id = Role::where(
            'slug', 'admin'
        )->firstOrFail()->id;

        $admin->save();

        $reader = User::firstOrNew([
            'email' => 'reader@nekomang.test',
        ]);

        if (!$reader->exists) {
            $reader->name = 'Reader';
            $reader->password = Hash::make('Reader12345!');
        }

        $reader->role_id = Role::where(
            'slug', 'reader'
        )->firstOrFail()->id;

        $reader->save();
    }
}
