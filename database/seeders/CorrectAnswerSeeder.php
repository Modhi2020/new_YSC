<?php

namespace Database\Seeders;

use App\Models\CorrectAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CorrectAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('correct_answers')->delete();
       
            CorrectAnswer::create([
                'name' =>  ['en'=> 'Frist answer', 'ar'=> 'الإجابة الأولى'],
                'correct_ans' => 'frist_answer']);

            CorrectAnswer::create([
                'name' =>  ['en'=> 'Second answer', 'ar'=> 'الإجابة الثانية'],
                'correct_ans' => 'second_answer']);

            CorrectAnswer::create([
                'name' =>  ['en'=> 'Third answer', 'ar'=> 'الإجابة الثالثة'],
                'correct_ans' => 'third_answer']);

            CorrectAnswer::create([
                'name' =>  ['en'=> 'Fourth answer', 'ar'=> 'الإجابة الرابعة'],
                'correct_ans' => 'fourth_answer']);
        
    }
}
