<?php

namespace Database\Seeders;

use App\Models\WorkCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkCenter::create([
            'name'=> 'Wharehouse 1'
        ]);
        WorkCenter::create([
            'name'=> 'Wharehouse 2'
        ]);
        WorkCenter::create([
            'name'=> 'Wharehouse 3'
        ]);

    }
}
