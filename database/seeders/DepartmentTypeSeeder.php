<?php

namespace Database\Seeders;

use App\Models\DepartmentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DepartmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_types')->delete();
        $AgreeSt = [
            ['en'=> 'Main management', 'ar'=> 'أساسي'],
            ['en'=> 'Sub-management', 'ar'=> 'فرعي'],

        ];
        foreach ($AgreeSt as $as) {
            DepartmentType::create(['name' => $as]);
        }
    }
}
