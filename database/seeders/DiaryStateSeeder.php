<?php

namespace Database\Seeders;

use App\Models\DiaryState;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DiaryStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diary_states')->delete();
        $AgreeSt = [
            ['en'=> 'Pending', 'ar'=> 'معلقه'],
            ['en'=> 'Delivered', 'ar'=> 'تم التسليم'],
            ['en'=> 'Not delivered', 'ar'=> 'لم يتم التسليم'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            DiaryState::create(['name' => $as]);
        }
    }
}
