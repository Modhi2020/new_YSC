<?php

namespace Database\Seeders;

use App\Models\TaskDegree;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TaskDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_degrees')->delete();
        $AgreeSt = [
            ['en'=> 'Urgent', 'ar'=> 'عاجلة'],
            ['en'=> 'Necessary', 'ar'=> 'مهمة'],
            ['en'=> 'Normal', 'ar'=> 'عادية'],
            ['en'=> 'Medium', 'ar'=> 'متوسطة'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            TaskDegree::create(['name' => $as]);
        }
    }
}
