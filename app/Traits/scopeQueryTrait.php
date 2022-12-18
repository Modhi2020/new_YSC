<?php 

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Scope; 
use Auth;
use App\Models\User;
use App\Models\Users_of_school;
use App\Models\Users_of_directorate;
use App\Models\Users_of_governances;
use App\Models\Directorate;
use App\Models\Academic_year;
use App\Models\School;
use App\Models\Teacher;
use App\Models\My_Parent;
use App\Models\Student;
use App\Models\Student_record;
use App\Models\TeacherRecord;


/**
 * 
 */
Trait scopeQueryTrait
{
    public function scopeQueryTrait(Builder $builder, Model $model,$ScopeType = null)
    {
        // $usId = Auth::user()->id;
        // $usRoles = Auth::user()->roles_name;
        // $acadimicYears = Academic_year::where('default_academicYear',1)->value('id');

        // if ($scopeTable == 'modhi') 
        // {
        //     # code...
        // }

        //  // check Sections of governances                                 
        //     $Scopes = $ScopeModel::
        //     whereIn($firstClomun, function($query) use($usId){
        //     $query->select($secoundClomun)->from($scopeTable)
        //     ->where($thirdClomun,'=',$usId);})->get();

        //     if ($Scopes->count() > 0 ) 
        //     {
        //         foreach ($Scopes as $Scope) 
        //         {
        //             $list_Schools[] = $Scope->id;
        //         }

        //         return $builder->where('Select','=', 1)->whereIn($targetClomun, $list_Schools); 
        //     }

        //     else 
        //     {
        //         return $builder->where('Select', '=', 1)->where('id',-1);  
        //     }  
            
    /*========================================*/
     /*========== get user id & roles_name =======*/
     $usId = Auth::user()->id;
     $usRoles = Auth::user()->roles_name;
     $acadimicYears = Academic_year::where('default_academicYear',1)->value('id');
     
    // check permission of Directorate users
    if(($usRoles === "directorate" ) || ($usRoles === "directorate_assistant" ) || ($usRoles === "Director_Control_of_directorate" ) )
    {
        // if ($ScopeType == 'directorate') 
        // {
        //     $Directorates = Users_of_directorate::where('user_id','=',$usId)->value('directorate_id');
        //   return  $builder->where('Select','=', 1)->where('id', '=', $Directorates);   
        // }

        // $SchoolsIDs = School::
        // whereIn('Directorates_id', function($query) use($usId){
        // $query->select('directorate_id')->from('users_of_directorates')
        // ->where('user_id','=',$usId);})->get();

        // if ($SchoolsIDs->count() > 0 ) 
        // {
        //     foreach ($SchoolsIDs as $SchoolsID) 
        //     {
        //         $ListSchools[] = $SchoolsID->id;
        //     }

        //       return  $builder->where('Select','=', 1)->whereIn('school_id', $ListSchools); 
        // }
        // else 
        // {
        //     return  $builder->where('Select','=', 1)->where('id',-1); 
        // }
        return $builder->where('Select','=', 1);

    }

    // check permission of School user
    elseif(($usRoles === "school" ) || ($usRoles === "school_assistant" ) || ($usRoles === "Director_Control_of_School" ) || ($usRoles === "Librarian" ) || ($usRoles === "Accounts_manager" ) || ($usRoles === "school_visitor" ) )
    {
        // $School_Users = Users_of_school::where('user_id','=',$usId)->value('school_id');

        // if ($School_Users <> null ) 
        // {
        //     return  $builder->where('Select','=', 1)->where('school_id', $School_Users); 
        // }
        // else 
        // {
        //     return  $builder->where('Select','=', 1)->where('id', -1); 
        // }
        return $builder->where('Select','=', 1);
    } 

    // check permission of Teacher user
    elseif($usRoles === "teacher" )
    {                
        // $Teachers = TeacherRecord::where('teacher_id','=',$usId)->where('academic_year_id','=',$acadimicYears)->get();

        // if (($Teachers->count() > 0) && ($Teachers->count() < 2))
        // {
        //     foreach($Teachers as $Teacher)
        //     {
        //         $ListSchools = $Teacher->school_id;
        //     }

        //     return  $builder->where('Select','=', 1)->where('school_id', $ListSchools);       
        // }

        // elseif($Teachers->count() > 1) 
        // {
        //     foreach($Teachers as $Teacher)
        //     {
        //         $ListSchools[] = $Teacher->school_id;
        //     }

        //     return  $builder->where('Select','=', 1)->whereIn('school_id', $ListSchools);           
        // }

        // else 
        // {
        //     $builder->where('Select','=', 1)->where('id', -1); 
        // }
        return $builder->where('Select','=', 1);
    } 


    // check permission of guardian user
    elseif($usRoles === "guardian" )
    {
        // $guardians = Student::where('parent_id','=',$usId)->get();

        //   // get students ID
        // if (($guardians->count() > 0) && ($guardians->count() < 2))
        // {
        //     foreach($guardians as $guardian)
        //     {
        //         $ListStudents = $guardian->id;
        //     }
        //     $SchoolsIDs = Student_record::where('student_id' ,$ListStudents)->where('academic_year_id','=',$acadimicYears)->value('school_id');

        //     return  $builder->where('Select','=', 1)->where('id', $ListSchools); 
        // }

        // elseif($guardians->count() > 1) 
        // {
        //     foreach($guardians as $guardian)
        //     {
        //         $ListStudents[] = $guardian->id;
        //     }
        
        //     $SchoolsIDs = Student_record::whereIn('student_id' ,$ListStudents)->where('academic_year_id','=',$acadimicYears)->get();
    
        //     // get Schools ID
        //     foreach($SchoolsIDs as $SchoolsID)
        //     {
        //         $ListSchools[] = $SchoolsID->school_id;
        //     }

        //     return  $builder->where('Select','=', 1)->whereIn('id', $ListSchools); 
        // }
        
        // else 
        // {
        //     return $builder->where('Select','=', 1)->where('id', -1); 
        // }
        return $builder->where('Select','=', 1);
    } 

    // check permission of Student user
    elseif($usRoles === "student" )
    {      
    
        // $Students = Student_record::where('student_id','=',$usId)->where('academic_year_id','=',$acadimicYears)->value('school_id');
        // if ($Students <> null) 
        // {
        //     return $builder->where('Select','=', 1)->where('school_id', '=',  $Students); 
        // }

        // else 
        // {
        //     return $builder->where('Select','=', 1)->where('id', -1); 
        // }
        return $builder->where('Select','=', 1);
        
    } 

    elseif(($usRoles === "governances" ) || ($usRoles === "governances_assistant" ) || ($usRoles === "Director_Control_of_governances" ))
    {
    
        // $Governances = Users_of_Governances::where('user_id','=',$usId)->value('governances_id');
        return $builder->where('Select','=', 1);
        // $Directorates = Directorate::where('governances_id','=',$Governances)->get();

        // if (($Directorates->count() > 0) && ($Directorates->count() < 2))
        // {
        //     foreach ($Directorates as $Directorate) 
        //     {
        //         $ListDirectorates = $Directorate->id;
        //     }

        //     $SchoolsIDs = School::where('Select','=', 1)->where('Directorates_id', $ListDirectorates)->value('id'); 
        //      // get Schools ID
        //      if ($SchoolsIDs <> null ) 
        //      {
        //         // return $builder->where('Select','=', 1)->where('school_id', $SchoolsIDs); 
        //         return $builder->where('Select','=', 1);
        //      }
        //      else 
        //      {
        //         return $builder->where('Select','=', 1)->where('id', -1); 
        //      }
        // }

        // elseif ($Directorates->count() > 1 ) 
        // {
        //     foreach ($Directorates as $Directorate) 
        //     {
        //         $ListDirectorates[] = $Directorate->id;
        //     }

        //     $SchoolsIDs = School::where('Select','=', 1)->whereIn('Directorates_id', $ListDirectorates); 
        //      // get Schools ID
        //      if ($SchoolsIDs->count() > 0 ) 
        //      {
        //         foreach($SchoolsIDs as $SchoolsID)
        //         {
        //             $ListSchools[] = $SchoolsID->id;
        //         }
        //         // return $builder->where('Select','=', 1)->whereIn('school_id', $ListSchools); 
        //         return $builder->where('Select','=', 1);
        //      }
        //      else 
        //      {
        //         return $builder->where('Select','=', 1)->where('id', -1); 
        //      }

        // }
        // else 
        // {
        //     return $builder->where('Select','=', 1)->where('id', -1); 
        // }

    } 

    // check permission of Super admin user
    elseif($usRoles === "super_admin" )
    {
        return $builder->where('Select',1); 
    }
    
    // check permission of Owner user
    elseif($usRoles === "owner" )
    {
        $stArray = [0,1];
        return $builder->whereIn('Select',$stArray); 
    }
    else
    {
        return $builder->where('Select', '=', 1)->where('id',-1); 
    } 

 }
    
}



?>