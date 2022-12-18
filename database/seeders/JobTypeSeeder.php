<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_types')->delete();
        $AgreeSt = [
            ['en'=> 'Admin', 'ar'=> 'مديـر'],
            ['en'=> 'Supervisor', 'ar'=> 'مشـرف'],
            ['en'=> 'Imam', 'ar'=> 'امـام جامع'],
            ['en'=> 'preacher', 'ar'=> 'خطيـب'],
            ['en'=> 'Muzzin', 'ar'=> 'مؤذن'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            JobType::create(['name' => $as]);
        }
    }
}
