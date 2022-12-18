<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Myevent;
use Illuminate\Support\Facades\DB;

class MyeventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('myevents')->delete();

        $Myevents = new Myevent();
        $Myevents->title = ['en' => 'Awqaf office App', 'ar' => 'تطبيق مكتب الأوقاف'];
        $Myevents->details = ['en' => 'The Al-Awqaf and Guidance Office launches the first trial version of Azan application in Taiz Governorate', 'ar' => 'مكتب الأوقاف والإرشـاد يطلق النسخة التجريبية الأولى لبرنامج الأذان في محافظة تعز'];
        $Myevents->slug = 'Awqaf office App';
        $Myevents->ready = 1;
        $Myevents->date = date('Y-m-d');
        $Myevents->files = '/assets/app/awqaf.apk';
        // $news->type = $request->type;
        // $news->url_link = $request->video;
        $Myevents->save();
    }
}
