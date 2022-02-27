<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Group;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::factory()
            ->count(10)
            ->create();
    }
}
