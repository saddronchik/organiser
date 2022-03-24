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
//        $this->call([
//            StatusesSeeder::class
//        ]);

//        \App\Models\Department::factory(10)->create();
//         \App\Models\User::factory(20)->create();
        \App\Models\Assignment::factory(50)->create();
    }
}
