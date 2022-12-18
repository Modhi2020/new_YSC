<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->delete();
        $UserTy = [
            ['en'=> 'Owner', 'ar'=> 'المــالك'],
            ['en'=> 'Super Admin', 'ar'=> 'مدير النظام'],
            ['en'=> 'Manager', 'ar'=> 'مديـر'],
            ['en'=> 'Supervisor', 'ar'=> 'مشـرف'],
            ['en'=> 'Secretarial', 'ar'=> 'سكرتارية'],
            ['en'=> 'Teacher', 'ar'=> 'معلم'],
            ['en'=> 'Student', 'ar'=> 'طالب'],
            ['en'=> 'Visitor', 'ar'=> 'زائر'],
            ['en'=> 'Custom', 'ar'=> 'مخصص'],

        ];
        $roles =  array(
            'owner','super_admin',
            'manager','supervisor','secretarial',
            'teacher','student','visitor','custom',
        
        );
        $count = 0;
        foreach ($UserTy as $ust) {
            UserType::create(['name' => $ust, 'roles_name'=> $roles[$count++] ]);
        }
    }
}
