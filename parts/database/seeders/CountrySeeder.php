<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'code'=> 'CH',
            'name'=>'China'
        ]);
        Country::create([
            'code'=> 'TW',
            'name'=>'Taiwan'
        ]);
        Country::create([
            'code'=> 'MX',
            'name'=>'Mexico'
        ]);
        Country::create([
            'code'=> 'US',
            'name'=>'United States'
        ]);
    }
}
