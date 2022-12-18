<?php

namespace Database\Seeders;

use App\Models\DenouncementType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DenouncementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denouncement_types')->delete();
        $AgreeSt = [
            ['en'=> 'Dangerous', 'ar'=> 'خطيـر'],
            ['en'=> 'Normal', 'ar'=> 'عـادي'],

        ];
        foreach ($AgreeSt as $as) {
            DenouncementType::create(['name' => $as]);
        }
    }
}
