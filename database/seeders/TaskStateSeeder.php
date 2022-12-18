<?php

namespace Database\Seeders;

use App\Models\TaskState;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TaskStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_states')->delete();
        $AgreeSt = [
            ['en'=> 'Underway', 'ar'=> 'قيد التنفيذ'],
            ['en'=> 'Successfully', 'ar'=> 'تمت بنجاح'],
            ['en'=> 'Failed', 'ar'=> 'فشلت'],
            ['en'=> 'Pending', 'ar'=> 'معلقة'],
            ['en'=> 'Other', 'ar'=> 'أخـرى'],

        ];
        foreach ($AgreeSt as $as) {
            TaskState::create(['name' => $as]);
        }
    }
}
