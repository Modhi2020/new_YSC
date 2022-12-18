<?php 

namespace App\Traits;
use App\Models\User;
use App\Models\Student_record;
use App\Models\Academic_year;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Fee;
use App\Models\Setting;
use Auth;


/**
 * 
 */
Trait accountsTrait
{
    public function accountsTrait($studentID = null, $currencyID = null,$reqAmount = null)
    {
        $acadimicYears = Academic_year::where('default_academicYear',1)->value('id');
        $SchoolID = Student_record::where('student_id',$studentID)
            ->where('academic_year_id',$acadimicYears)->value('school_id');
       
        $Fee_currency = Setting::where('school_id',$SchoolID)
        ->where('academic_year_id',$acadimicYears)->value('currency_id');

        if ($Fee_currency <> $currencyID ) 
        {
            if( $currencyID <> 1)
            {
                $currency_rate = Exchange::where('date',date('Y-m-d'))->where('currency_id',$currencyID)
                ->where('school_id',$SchoolID)
                ->where('academic_year_id',$acadimicYears)->value('amount');
                if($currency_rate == null)
                {
                    toastr()->error(trans('messages.currncyMsg'));
                    return redirect()->route('exchanges.index');
                }
            }
            else 
            {
                $currency_rate = 1;
            }
            
            $amount = $currency_rate * $reqAmount;
        }

        else 
        {
            $currency_rate = Exchange::where('date',date('Y-m-d'))->where('currency_id',$currencyID)
            ->where('school_id',$SchoolID)
            ->where('academic_year_id',$acadimicYears)->value('amount');
            if($currency_rate == null)
            {
                toastr()->error(trans('messages.currncyMsg'));
                return redirect()->route('exchanges.index');
            }

            $amount = $currency_rate * $reqAmount;
        }

            return $amount;   
        
    }
    
}



?>