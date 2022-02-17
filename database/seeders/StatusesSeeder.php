<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{

    private $statuses = [
        'Выполнено' => '#2de0865b',
        'Просрочено' => 'rgba(240, 138, 138, 0.200)',
        'Без статуса' => '#eee'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->statuses as $status => $color) {
            DB::table('statuses')
                ->insert([
                    'status' => $status,
                    'color' => $color
                ]);
        }

    }
}
