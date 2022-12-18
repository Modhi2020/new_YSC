<?php 

namespace App\Traits;
use App\Models\User;
use App\Models\Student_record;
use App\Models\StudentAccount;
use App\Models\Academic_year;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Fee;
use App\Models\Setting;
use Auth;


/**
 * 
 */
Trait finalBalanceTrait
{
    public function finalBalanceTrait($studentID = null)
    {
        $acadimicYears = Academic_year::where('default_academicYear',1)->value('id');
        $SchoolID = Student_record::where('student_id',$studentID)
            ->where('academic_year_id',$acadimicYears)->value('school_id');
       
        $Fee_currency = Setting::where('school_id',$SchoolID)
        ->where('academic_year_id',$acadimicYears)->value('currency_id');

        $realDebit = 0;
        $reacredit = 0;
        if ($Fee_currency <> 1 ) 
        {   
            $data = StudentAccount::where("student_id", $studentID)->where('academic_year_id',$acadimicYears)->get();
            foreach ($data as $da) 
            {
                $rate = Exchange::where('date','=',$da->date)->where('currency_id','=',$Fee_currency)
                ->value('amount');
                $realDebit += $da->Debit / $rate;
                $reacredit += $da->credit / $rate;
            }

             $final_balance = number_format(($reacredit - $realDebit), 2);
            // $final_balance = 20;
        }

        else 
        {
            $Debit = StudentAccount::where("student_id", $studentID)->where('academic_year_id',$acadimicYears)->sum('Debit');
            $credit = StudentAccount::where("student_id", $studentID)->where('academic_year_id',$acadimicYears)->sum('credit');
           
            $final_balance = number_format(($Debit - $credit), 2);

        }
        // $final_balance =100;
            return $final_balance;   
        
    }
    
}



?>