<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_types')->delete();

        $attend = [
            ['en'=> 'Apartment', 'ar'=> 'شقــة'],
            ['en'=> 'House', 'ar'=> 'منـــزل'],
            ['en'=> 'Shop', 'ar'=> 'دكــان'],
        ];
      
        foreach ($attend as $at) {
            PropertyType::create(['name' => $at]);
        }
    }
}
