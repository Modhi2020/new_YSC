<?php

namespace Database\Seeders;

use App\Models\PostApproved;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PostApprovedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_approveds')->delete();

        $attend = [
            ['en'=> 'Approved', 'ar'=> 'تمت الموافقة'],
            ['en'=> 'Pending', 'ar'=> 'معلـق'],
            ['en'=> 'Rejection', 'ar'=> 'تم الرفض'],
        ];

        foreach ($attend as $at) {
            PostApproved::create(['name' => $at]);
        }
    }
}
