<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SideType;
use Illuminate\Support\Facades\DB;

class SideTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sides_types')->delete();
        $AgreeSt = [
            ['en'=> 'Primary', 'ar'=> 'رئيسي'],
            ['en'=> 'Sub', 'ar'=> 'فرعي'],
            ['en'=> 'Sub level 2', 'ar'=> 'فرعي مستوى 2'],
            ['en'=> 'Sub level 3', 'ar'=> 'فرعي مستوى 3'],
            ['en'=> 'Sub level 4', 'ar'=> 'فرعي مستوى 4'],
            ['en'=> 'Sub level 5', 'ar'=> 'فرعي مستوى 5'],
            ['en'=> 'Sub level 6', 'ar'=> 'فرعي مستوى 6'],
            ['en'=> 'Sub level 7', 'ar'=> 'فرعي مستوى 7'],
            ['en'=> 'Sub level 8', 'ar'=> 'فرعي مستوى 8'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            SideType::create(['name' => $as]);
        }
    }
}
