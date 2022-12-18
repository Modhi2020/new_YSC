<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\Opportunity;
use App\Models\StudentAnswer;
use App\Models\SurveysOpportunity;
use Auth;

class Myopportunity extends Component
{
   
    public $mb = 10;

    

    public $successMessage = '';

    public $items = [];

    public $data = [];
    public $questions = [];
    public $firstAnswers = [];
    public $secondAnswers = [];
    public $thirdAnswers = [];
    public $fourAnswers = [];
    public $score = [];
    public $answers = [];
    public $arr = [];


    // public Field::make('answers')->radio(['asd','dfg','fff']);

    public $count;
    public $asd ;

    public $catchError,$updateMode = false,$show_table = true;

    public $currentStep = 1;
    public $step = 0;
    public $opportunity_id = 0;
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
    public $status;
    public $studentID;
    public $schoolID;
    public $back_status = false;
    public $showResult = false ;
    public $show_qutesions = true ;
    public $test = 123 ;
    public $abc = 1 ;

    public $mysurveys ;
 
    public function mbmb()
    {
        $this->mb = 20;
        $this->abc++;
        $this->count++;
    }

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        // return view('livewire.opportunity');

        if ( $this->opportunity_id == 0) 
        {
            return view('livewire.myopportunity',
            // return view('livewire.steps',
            [
                'opportunities' => Opportunity::get(),
                'Surveys' => Survey::get(),
            ]);
        }
        else 
        {
        //    $fff =$this->opportunity_id;
        //     $mysurveys = Survey::whereIn('id', function($query) use ($fff){
        //         $query->select('survey_id')->from('surveys_opportunities')
        //         ->where('opportunity_id',$fff);
        //     })->get();
            return view('livewire.myopportunity',
            [
                // 'Surveys' => $this->mysurveys,
                'Surveys' => Survey::get(),
                'opportunities' => Opportunity::get(),
            ]);
        }
    }

    public function showform()
    {

        $this->show_table = false;
        $this->count++;
        $this->mb++;
    }
    
    public function showformadd($opportunity_id)
    {

        $this->show_table = false;
        $this->opportunity_id = $opportunity_id;
        // $this->studentID = Auth::user()->id;
        $this->studentID = 1;


        // $Surveys = Survey::where('opportunity_id',$opportunity_id)->get();
        
          $Surveys = Survey::whereIn('id', function($query) use ($opportunity_id){
                $query->select('survey_id')->from('surveys_opportunities')
                ->where('opportunity_id',$opportunity_id);
            })->get();
        // $Surveys = Survey::get();
        if($Surveys->count() >= 1)
        {
            $this->count = $Surveys->count();
            foreach ($Surveys as $Survey ) 
            {
                array_push($this->questions , $Survey->questions);
                // array_push($this->questions , $Survey->questions);
                array_push($this->firstAnswers ,  $Survey->frist_answer);
                array_push($this->secondAnswers , $Survey->second_answer);
                array_push($this->thirdAnswers , $Survey->third_answer);
                array_push($this->fourAnswers , $Survey->fourth_answer);
                // array_push($this->score , $Survey->degree);
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
    public function next($step,$Survey,$ans)
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
            $Surveys = Survey::where('id',$Survey)->first();
            if ($Surveys->right_answer === $ans ) 
            {
                $degree = $Survey->score;
            }
            else 
            {
                $degree = 0.00;
            }
           
            $StudentAnswers = StudentAnswer::where('Survey_id',$Survey)
            ->where('student_id',$this->studentID)->first();
            
            if($StudentAnswers != null)
            {
                StudentAnswer::where('Survey_id',$Survey)
                ->where('student_id',$this->studentID)
                ->update([
                    'Survey_id'=>$Survey,
                    'opportunity_id'=>$this->opportunity_id,
                    'answers'=>$ans,
                    'score'=>$degree,
                     ]);
            }
            else 
            {
                StudentAnswer::updateOrCreate([
                    'student_id'=>$this->studentID,
                    'Survey_id'=>$Survey,
                    'opportunity_id'=>$this->opportunity_id,
                    'answers'=>$ans,
                    'score'=>$degree,
                     ]);  
            }


            if ($step < $this->count) 
            {
                $this->answers = [];
                $this->step = $step + 1;
                $this->currentStep = $this->step;

                $this->back_status = true;
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


        $this->std_score = StudentAnswer::where('student_id',$this->studentID)
        ->where('opportunity_id',$this->opportunity_id)
        ->sum('score'); 
        
        $this->result_true = StudentAnswer::where('student_id',$this->studentID)
        ->where('opportunity_id',$this->opportunity_id)
        ->where('score','<>',0.00)
        ->count(); 

        $results = StudentAnswer::where('student_id',$this->studentID)
        ->where('opportunity_id',$this->opportunity_id)
        ->first();

        // $this->total_qutesions = Survey::where('opportunity_id',$this->opportunity_id)
        // ->count();

        $oopid = $this->opportunity_id;

        $this->total_qutesions = Survey::whereIn('id', function($query) use ($oopid){
            $query->select('survey_id')->from('surveys_opportunities')
            ->where('opportunity_id',$oopid);
        })->count();

        // $this->total_scores = Survey::where('opportunity_id',$this->opportunity_id)
        // ->sum('score'); 

        // $this->total_scores= Survey::whereIn('id', function($query) use ($oopid){
        //     $query->select('survey_id')->from('surveys_opportunities')
        //     ->where('opportunity_id',$oopid);
        // })->sum('score'); 

        // {{ number_format($student->student_account->sum('Debit') - $student->student_account->sum('credit'), 2) }}

        if($results <> null)
        {
            $this->std_name = $results->students->name;
            $this->quizze = $results->opportunities->title;
        }
        
        $this->show_qutesions = false;
        $this->showResult = true;
        //  $this->bm =   $this->items['id'];


     }
}
