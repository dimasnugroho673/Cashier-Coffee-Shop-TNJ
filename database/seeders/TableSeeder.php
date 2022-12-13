<?php

namespace Database\Seeders;

use App\Models\Tables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tables::create([
            'number' => 1,
            'desc' => 'Sedang dalam perbaikan'
        ]);

        Tables::create([
            'number' => 2,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 3,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 4,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 5,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 6,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 7,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 8,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 9,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 10,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 11,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 12,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 13,
            'desc' => ''
        ]);

        Tables::create([
            'number' => 14,
            'desc' => ''
        ]);

    }
}
