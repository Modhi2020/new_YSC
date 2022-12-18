<?php

namespace Database\Seeders;

use App\Models\IncentivesType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class IncentivesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incentives_types')->delete();
        $AgreeSt = [
            ['en'=> 'Incentives', 'ar'=> 'حوافـز'],
            ['en'=> 'Sanctions', 'ar'=> 'جـزاءات'],

        ];
        foreach ($AgreeSt as $as) {
            IncentivesType::create(['name' => $as]);
        }
    }
}
