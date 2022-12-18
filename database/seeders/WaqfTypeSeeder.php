<?php

namespace Database\Seeders;

use App\Models\WaqfType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class WaqfTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('waqf_types')->delete();
        $AgreeSt = [
            ['en'=> 'Lands', 'ar'=> 'أراضي'],
            ['en'=> 'Real estates', 'ar'=> 'عقـارات'],
            ['en'=> 'Mosques', 'ar'=> 'مساجد'],
            ['en'=> 'Hosbitals', 'ar'=> 'مستشفيات'],
            ['en'=> 'Libraries', 'ar'=> 'مكتبات'],
            ['en'=> 'Vehicles', 'ar'=> 'مركبات'],
            ['en'=> 'wells', 'ar'=> 'آبـار'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            WaqfType::create(['name' => $as]);
        }
    }
}
