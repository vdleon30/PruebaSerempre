<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DataTypesTableSeeder::class,
            DataRowsTableSeeder::class,
            MenusTableSeeder::class,
            MenuItemsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            SettingsTableSeeder::class,
        ]);
        \App\Models\User::create([
            'name' => "Admin",
            'email' => "admin@admin.com",
            'email_verified_at' => now(),
            'password'      => Hash::make("admin1234"),
            'remember_token' => Str::random(10),
            'photo' => "img/default.jpg",
            'role_id' => 1,
        ]);

        \App\Models\User::create([
            'name' => "User",
            'email' => "user@user.com",
            'email_verified_at' => now(),
            'password'      => Hash::make("test1234"),
            'remember_token' => Str::random(10),
            'photo' => "img/default.jpg",
        ]);
    }
}
