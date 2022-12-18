<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_types')->delete();
        $AgreeSt = [
            ['en'=> 'Article', 'ar'=> 'مقـالي'],
            ['en'=> 'Choices', 'ar'=> 'إختيـارات'],
            ['en'=> 'Multi Choice', 'ar'=> 'إختيـار متعـدد'],
            ['en'=> 'True & False', 'ar'=> 'صـح وخطـأ'],

        ];
        foreach ($AgreeSt as $as) {
            QuestionType::create(['name' => $as]);
        }
    }
}
