<?php

namespace App\Http\Livewire\Exams;

use Livewire\Component;
use App\Models\Grade;
use App\Models\Quizze;
use App\Models\Question;
use App\Models\Student_answer;
use App\Models\Exam_role;
use App\Models\Academic_year;
use App\Models\Student_record;
use Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class StartExam extends Component
{
    

    public $successMessage = '';

    public $items = [];

    public $data = [];
    public $title = [];
    public $firstAnswers = [];
    public $secondAnswers = [];
    public $thirdAnswers = [];
    public $fourAnswers = [];
    public $score = [];
    public $answers = [];

    // public Field::make('answers')->radio(['asd','dfg','fff']);

    public $count;
    public $asd ;

    public $catchError,$updateMode = false,$show_table = true;

    public $currentStep = 1;
    public $step = 0;
    public $quizze_id = 0;
    public $resultMode = false;
    public $quizze ;
    public $std_score ;
    public $std_name ;
    public $academicYears ;
    public $result_true ;
    public $total_scores ;
    public $total_qutesions ;
    public $exam_period;
    public $available_time_start;
    public $available_time_end;
    public $time_now;
    public $timeEnd;
    public $sumTime;
    public $showTime;
    public $Status;
    public $studentID;
    public $schoolID;
    public $back_status = false;
    public $showResult = false ;
    public $show_qutesions = true ;

    
     // Question_INPUTS
    //  $title, $firstAnswers,
    //  $secondAnswers, $thirdAnswers,
    //  $fourAnswers, $right_answer,
    //  $score, $quizze_id;

    public function render()
    {
       
        if ( $this->quizze_id == 0) 
        {
            return view('livewire.exams.start-exam',
            [
                'Quizzes' => Quizze::get(),
            ]);
        }
        else 
        {
            return view('livewire.exams.start-exam',
            [
                'Questions' => Question::where('quizze_id', $this->quizze_id)->get(),
                'Quizzes' => Quizze::get(),
            ]);
        }
       
    }

    public function showformadd($quizze_id)
    {

        $this->show_table = false;
        $this->quizze_id = $quizze_id;
        $this->academicYears = Academic_year::where('default_academicYear',1)->value('id');
        $this->studentID = Auth::user()->id;
        $this->schoolID = Student_record::where('student_id',$this->studentID)
        ->where('academic_year_id',$this->academicYears)->value('school_id');

     
        if ($this->schoolID == null ) 
        {
            toastr(1000)->error(trans('messages.acadYearMsg'));
            return redirect()->route('dashboard'); 
        }

        $this->Status = Student_answer::where('quizze_id',$this->quizze_id)
        ->where('student_id',$this->studentID)->where('academic_year_id',$this->academicYears)
        ->value('Status');
        
        if(($this->Status <> null) && ($this->Status == 1))
        {
            toastr(1000)->error(trans('messages.acadYearMsg'));
             //return redirect()->route('dashboard'); 
        }

        Student_answer::where('quizze_id',$this->quizze_id)
        ->where('student_id',$this->studentID)->where('academic_year_id',$this->academicYears)
        ->update([
            'Status'=>1,
             ]);



        $exam_roles = Exam_role::where('quizze_id',$quizze_id)
        ->where('academic_year_id',$this->academicYears)->first();

        if ($exam_roles != null) 
        {
            $this->exam_period = $exam_roles->exam_period;
            $this->available_time_start = $exam_roles->available_time_start;
            $this->available_time_end = $exam_roles->available_time_end;
         
            ///////////////
          
            $this->time_now = date('H:i:s');
            $this->time_now = strtotime($this->time_now );
            $this->timeEnd = date('H:i:s',strtotime('+'.$this->exam_period.' min'));
            $this->timeEnd = strtotime($this->timeEnd );
          

            $this->available_time_start = strtotime($this->available_time_start );
            $this->available_time_end = strtotime($this->available_time_end );

           

            $this->availableTime();
            $this->lifeTime();
 
           


    
    
               //return $sumTime;
        }

        $exam_method = Exam_role::where('quizze_id',$quizze_id)
        ->where('academic_year_id',$this->academicYears)->value('exam_method');

        if(($exam_method == 1) && ($exam_method <> null))
        {
            $this->back_status = true;
        }

        $Questions = Question::where('quizze_id',$quizze_id)->get();
        if($Questions->count() >= 1)
        {
            $this->count = $Questions->count();
            foreach ($Questions as $Question ) 
            {
                // array_push($this->title , $Question->getTranslation('title', 'ar'));
                array_push($this->title , $Question->title);
                array_push($this->firstAnswers , $Question->firstAnswers);
                array_push($this->secondAnswers , $Question->secondAnswers);
                array_push($this->thirdAnswers , $Question->thirdAnswers);
                array_push($this->fourAnswers , $Question->fourAnswers);
                array_push($this->score , $Question->score);
            // array_push(
                //   $this->items->fill( ['name'=>'modhi',]);            
            }
        }
    }

    public function availableTime()
    {

        if(!(($this->time_now  > $this->available_time_start ) && ($this->time_now  < $this->available_time_end )))
            {
                toastr(1000)->error(trans('messages.acadYearMsg'));
                return redirect()->route('dashboard');       
            }
    }

    public function lifeTime()
    {
       // $this->sumTime = $this->time_now - $this->timeEnd;
        //$this->sumTime = $this->sumTime / 60;

        // echo'<script> setInterval(function() {
            
        //     console.log("modhi");
        // }, 5000);</script>';       

        if($this->time_now  > $this->timeEnd)
            {
                toastr(1000)->error(trans('messages.acadYearMsg'));
                 return redirect()->route('dashboard'); 
                
            }
    }


    //next 
    public function next($step,$question,$ans)
    {
        $this->answers = [];
               
        if ($ans == null)
        {
           // $this->answers = 'addaaaa';
            array_push($this->answers ,trans('Exams_trans.should_select'));
            //$this->toastr()->error(trans('messages.nextYearMsg'));
            // return redirect()->back();
            
        }
        else 
        {
            $Question = Question::where('id',$question)->first();
            if ($Question->right_answer === $ans ) 
            {
                $degree = $Question->score;
            }
            else 
            {
                $degree = 0.00;
            }
           
            $StudentAnswers = Student_answer::where('question_id',$question)
            ->where('student_id',$this->studentID)->first();
            
            if($StudentAnswers != null)
            {
                Student_answer::where('question_id',$question)
                ->where('student_id',$this->studentID)
                ->update([
                    'question_id'=>$question,
                    'quizze_id'=>$this->quizze_id,
                    'answers'=>$ans,
                    'score'=>$degree,
                    'school_id'=>$this->schoolID,
                    'academic_year_id'=>$this->academicYears,
                     ]);
            }
            else 
            {
                Student_answer::updateOrCreate([
                    'student_id'=>$this->studentID,
                    'question_id'=>$question,
                    'quizze_id'=>$this->quizze_id,
                    'answers'=>$ans,
                    'score'=>$degree,
                    'school_id'=>$this->schoolID,
                    'academic_year_id'=>$this->academicYears,
                     ]);  
            }


            if ($step < $this->count) 
            {
                $this->answers = [];
                $this->step = $step + 1;
                $this->currentStep = $this->step;
                //$this->step++;
            }
            else
            {
                $this->resultMode = true;
            }            
        }     

    }

    //firstStepSubmit
    
     //back
     public function back($step)
     {
       
        if($step  != 0)
        {
            $step = $step - 1;
            $this->currentStep = $step ;
            $this->step--;
            $this->resultMode = false;
        }
         
     }
     public function closeComp()
     {

     }

     public function results()
     {


        $this->std_score = Student_answer::where('student_id',$this->studentID)
        ->where('quizze_id',$this->quizze_id)->where('academic_year_id',$this->academicYears)
        ->sum('score'); 
        
        $this->result_true = Student_answer::where('student_id',$this->studentID)
        ->where('quizze_id',$this->quizze_id)->where('academic_year_id',$this->academicYears)
        ->where('score','<>',0.00)
        ->count(); 

        $results = Student_answer::where('student_id',$this->studentID)
        ->where('quizze_id',$this->quizze_id)->where('academic_year_id',$this->academicYears)
        ->first();

        $this->total_qutesions = Question::where('quizze_id',$this->quizze_id)
        ->where('academic_year_id',$this->academicYears)->count();

        $this->total_scores = Question::where('quizze_id',$this->quizze_id)
        ->where('academic_year_id',$this->academicYears)->sum('score'); 

        // {{ number_format($student->student_account->sum('Debit') - $student->student_account->sum('credit'), 2) }}

        if($results <> null)
        {
            $this->std_name = $results->students->name;
            $this->quizze = $results->quizze->name;
        }
        
        $this->show_qutesions = false;
        $this->showResult = true;
        //  $this->bm =   $this->items['id'];


     }

}
