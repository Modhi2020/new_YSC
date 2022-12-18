<?php

namespace Database\Seeders;

use App\Models\SubmitMethod;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubmitMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submit_methods')->delete();
        $AgreeSt = [
            ['en'=> 'Online', 'ar'=> 'أونلاين'],
            ['en'=> 'Presence', 'ar'=> 'حضـوري'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            SubmitMethod::create(['name' => $as]);
        }
    }
}
