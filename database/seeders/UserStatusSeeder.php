<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserStatu;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_status')->delete();
        $UserSt = [
            ['en'=> 'Active', 'ar'=> 'نشط'],
            ['en'=> 'DisActive', 'ar'=> 'غير نشط'],

        ];
        foreach ($UserSt as $us) {
            UserStatu::create(['name' => $us]);
        }
    }
}
