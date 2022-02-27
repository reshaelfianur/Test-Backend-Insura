<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            ModuleTableSeeder::class,
            SubModuleTableSeeder::class,
            RoleTableSeeder::class,
            AccessModuleTableSeeder::class,
            PermissionTableSeeder::class,
            PermissionRoleTableSeeder::class,
            GroupTableSeeder::class,
            UserTableSeeder::class,
        ]);
    }
}
