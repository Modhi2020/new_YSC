<?php

namespace Database\Seeders;

use App\Models\SessionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SessionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('session_types')->delete();
        $AgreeSt = [
            ['en'=> 'Individual', 'ar'=> 'فردية'],
            ['en'=> 'Collective', 'ar'=> 'جماعية'],

        ];
        foreach ($AgreeSt as $as) {
            SessionType::create(['name' => $as]);
        }
    }
}
