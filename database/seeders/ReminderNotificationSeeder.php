<?php

namespace Database\Seeders;

use App\Models\ReminderNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ReminderNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reminder_notifications')->delete();
        $AgreeSt = [
            ['en'=> 'immediately', 'ar'=> 'فوري'],
            ['en'=> 'every day', 'ar'=> 'يومي'],
            ['en'=> 'every two days', 'ar'=> 'كل يومين'],
            ['en'=> 'every three days', 'ar'=> 'كل ثلاثة أيام'],
            ['en'=> 'every four days', 'ar'=> 'كل أربعة أيام'],
            ['en'=> 'every five days', 'ar'=> 'كل خمسة أيام'],
            ['en'=> 'every six days', 'ar'=> 'كل ستة أيام'],
            ['en'=> 'every week', 'ar'=> 'كل أسبوع'],


        ];
        $b =0;
        foreach ($AgreeSt as $as) {
            ReminderNotification::create(['name' => $as,
                                         'period' => $b++
        ]);
        }
    }
}
