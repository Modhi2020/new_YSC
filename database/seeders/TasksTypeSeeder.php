<?php

namespace Database\Seeders;

use App\Models\TasksType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TasksTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks_types')->delete();
        $AgreeSt = [
            ['en'=> 'Internal', 'ar'=> 'داخليـة'],
            ['en'=> 'External', 'ar'=> 'خارجيـة'],
            ['en'=> 'Internal and External', 'ar'=> 'داخليـة خارجيـة'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            TasksType::create(['name' => $as]);
        }
    }
}
