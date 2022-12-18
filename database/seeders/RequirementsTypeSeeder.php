<?php

namespace Database\Seeders;

use App\Models\RequirementsType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RequirementsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requirements_types')->delete();
        $AgreeSt = [
            ['en'=> 'Madi', 'ar'=> 'مـادي'],
            ['en'=> 'Moral', 'ar'=> 'معنوي'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            RequirementsType::create(['name' => $as]);
        }
    }
}
