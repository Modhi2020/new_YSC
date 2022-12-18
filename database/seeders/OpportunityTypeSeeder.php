<?php

namespace Database\Seeders;

use App\Models\OpportunityType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OpportunityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('opportunity_types')->delete();
        $AgreeSt = [
            ['en'=> 'Participation', 'ar'=> 'مشـاركة'],
            ['en'=> 'Occupation', 'ar'=> 'وظيفيـة'],

        ];
        foreach ($AgreeSt as $as) {
            OpportunityType::create(['name' => $as]);
        }
    }
}
