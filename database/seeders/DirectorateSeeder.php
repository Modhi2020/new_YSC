<?php

namespace Database\Seeders;

use App\Models\Directorate;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DirectorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directorates')->delete();
        $AgreeSt = [
            ['en'=> 'Al-Qahera directorate', 'ar'=> 'مديرية القاهرة'],
            ['en'=> 'Al-Modafr directorate', 'ar'=> 'مديرية المظفر'],
            ['en'=> 'Salaa directorate', 'ar'=> 'مديرية صالة'],
            ['en'=> 'Al-Taizya directorate', 'ar'=> 'مديرية التعزية'],
            ['en'=> 'Sharab Al-Rawnah directorate', 'ar'=> 'مديرية شرعب الرونة'],
            ['en'=> 'Sharab Al-Salam directorate', 'ar'=> 'مديرية شرعب السلام'],
            ['en'=> 'Al-Shmaiten directorate', 'ar'=> 'مديرية الشمايتين'],
            ['en'=> 'Al-Mafer directorate', 'ar'=> 'مديرية المعافر'],
            ['en'=> 'Al-Moaseet directorate', 'ar'=> 'مديرية المواسط'],
            ['en'=> 'Haifan directorate', 'ar'=> 'مديرية حيفان'],
            ['en'=> 'Al-Selo directorate', 'ar'=> 'مديرية الصلو'],
            ['en'=> 'Samea directorate', 'ar'=> 'مديرية سامع'],
            ['en'=> 'Khadeer directorate', 'ar'=> 'مديرية خدير'],
            ['en'=> 'Mashraa and Hadnan directorate', 'ar'=> 'مديرية مشرعة وحدنان'],
            ['en'=> 'Saber Al-Moadem directorate', 'ar'=> 'مديرية صبر الموادم'],
            ['en'=> 'Al-Mesrakh directorate', 'ar'=> 'مديرية المسراخ'],
            ['en'=> 'Habashi Jabal directorate', 'ar'=> 'مديرية جبل حبشي'],
            ['en'=> 'Maqbana directorate', 'ar'=> 'مديرية مقبنة'],
            ['en'=> 'Mawia directorate', 'ar'=> 'مديرية ماوية'],
            ['en'=> 'Al-Wazeaa directorate', 'ar'=> 'مديرية الوازعية'],
            ['en'=> 'Zabab directorate', 'ar'=> 'مديرية ذباب'],
            ['en'=> 'Mozaa directorate', 'ar'=> 'مديرية موزع'],
            ['en'=> 'Al-Mokha directorate', 'ar'=> 'مديرية المخاء'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            Directorate::create(['name' => $as,
                                'slug' => $as['en']
        ]);
        }
    }
}
