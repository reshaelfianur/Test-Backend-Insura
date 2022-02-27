<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('role_user')->truncate();
        DB::table('employees')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminUser = User::create(
            [
                'user_id'                       => 1,
                'email'                         => 'admin@admin.com',
                'username'                      => 'admin',
                'password'                      => Hash::make('admin1234'),
                'user_full_name'                => 'Admin',
                'user_type'                     => 1,
                'user_active_date'              => Carbon::now()->format('Y-m-d'),
            ],
        );

        $roleAdmin = Role::find(1);

        $roleAdmin->users()->attach($adminUser);

        $users = User::factory()
            ->count(100)
            ->create();

        $role = Role::find(2);

        $role->users()->attach($users);
    }
}
