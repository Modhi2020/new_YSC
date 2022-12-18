<?php 

namespace App\Traits;
use App\Models\User;
use App\Models\Student_record;
use App\Models\Academic_year;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Fee;
use App\Models\ReceiptStudent;
use Auth;


/**
 * 
 */
Trait updateAccountsTrait
{
    public function updateAccountsTrait($accountModel = null, $accountID = null, $amountClomun= null)
    {

              // $amounts =   // return $amounts ;inRandomOrder();
        $acadimicYears = Academic_year::where('default_academicYear',1)->value('id');
      
        $data = $accountModel::where('academic_year_id',$acadimicYears)->where('id',$accountID)->first();
       
            $rate = Exchange::where('date','=',$data->date)->where('currency_id','=',$data->currency_id)
            ->value('amount');
           $data->realAmount = $data->$amountClomun / $rate ;

        // $data = $accountModel::select('*')->selectRaw($accountTable.'.'.$amountClomun.' / ? as realAmount',[

        //     Exchange::crossJoin($accountTable, function($join) use($accountTable){
        //         $join->on($accountTable.'.date','=','exchanges.date')
        //         ->on($accountTable.'.currency_id','=','exchanges.currency_id');
        //     })->value('exchanges.amount') ])->where($accountTable.'.academic_year_id',$acadimicYears)->get();

            return $data;   
        
    }
    
}



?>