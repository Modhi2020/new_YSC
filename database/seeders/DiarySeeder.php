<?php

namespace Database\Seeders;

use App\Models\Diary;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diarys')->delete();
        $AgreeSt = [
            ['en'=> 'diary', 'ar'=> 'مذكرة'],
            ['en'=> 'image with greeting', 'ar'=> 'صورة مع التحية'],
            ['en'=> 'Guidance', 'ar'=> 'توجيـه'],
            ['en'=> 'Reply on diary', 'ar'=> 'رد على مذكرة'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            Diary::create(['name' => $as]);
        }
    }
}
