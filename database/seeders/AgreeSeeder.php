<?php

namespace Database\Seeders;

use App\Models\Agree;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AgreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agrees')->delete();
        $AgreeSt = [
            ['en'=> 'Agree', 'ar'=> 'أوافق'],
            ['en'=> 'Disagree', 'ar'=> 'لا أوافق'],

        ];
        foreach ($AgreeSt as $as) {
            Agree::create(['name' => $as]);
        }
    }
}
