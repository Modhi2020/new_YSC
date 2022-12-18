<?php

namespace Database\Seeders;

use App\Models\PostStatu;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_status')->delete();

        $attend = [
            ['en'=> 'Published', 'ar'=> 'تم النشـر'],
            ['en'=> 'Pending', 'ar'=> 'في الانتظار'],
        ];

        foreach ($attend as $at) {
            PostStatu::create(['name' => $at]);
        }
    }
}
