<?php

namespace Database\Seeders;

use App\Models\PropertyPurpose;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PropertyPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_purposes')->delete();

        $attend = [
            ['en'=> 'Rent', 'ar'=> 'إيحــار'],
            ['en'=> 'Sale', 'ar'=> 'بيــع'],
            ['en'=> 'Buy', 'ar'=> 'شــراء'],
        ];

        foreach ($attend as $at) {
            PropertyPurpose::create(['name' => $at]);
        }
    }
}
