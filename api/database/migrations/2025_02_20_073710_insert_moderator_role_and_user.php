<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InsertModeratorRoleAndUser extends Migration
{
    public function up(): void
    {
        // Insert the 'moderator' role
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'moderator',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Insert a Moderator Admin user
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Moderator Admin',
            'email' => 'jemsbond1109@mailinator.com',
            'email_verified_at' => null,
            'password' => Hash::make('123456'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'role_id' => 1,
        ]);
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'jemsbond1109@mailinator.com')->delete();
        DB::table('roles')->where('name', 'moderator')->delete();
    }
}
