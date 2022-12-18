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
Trait showAccountsTrait
{
    public function showAccountsTrait($accountModel = null, $accountTable = null, $amountClomun= null)
    {

              // $amounts =   // return $amounts ;inRandomOrder();
        $acadimicYears = Academic_year::where('default_academicYear',1)->value('id');
      
        $data = $accountModel::where('academic_year_id',$acadimicYears)->paginate(Pagination_count);
        foreach ($data as $da) 
        {
            $rate = Exchange::where('date','=',$da->date)->where('currency_id','=',$da->currency_id)
            ->value('amount');
           $da->realAmount = $da->$amountClomun / $rate ;
        }

        // $data = $accountModel::select('*')->selectRaw($accountTable.'.'.$amountClomun.' / ? as realAmount',[

        //     Exchange::crossJoin($accountTable, function($join) use($accountTable){
        //         $join->on($accountTable.'.date','=','exchanges.date')
        //         ->on($accountTable.'.currency_id','=','exchanges.currency_id');
        //     })->value('exchanges.amount') ])->where($accountTable.'.academic_year_id',$acadimicYears)->get();

            return $data;   
        
    }
    
}



?>