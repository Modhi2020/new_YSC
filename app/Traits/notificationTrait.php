<?php 

namespace App\Traits;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Add_notice;
use App\Notifications\Subjects\update_subject;
use App\Notifications\Subjects\delete_subject;
use App\Notifications;
use Auth;


/**
 * 
 */
Trait notificationTrait
{
    public function notificationTrait($noticeName = null, $data = null,$data_old = null)
    {
       
        $user = User::where('roles_name','LIKE','%governances%')->orWhere('roles_name','LIKE','%owner%')->get();

        if ($data_old == null) 
        {
            return Notification::send($user, new $noticeName( $data ));
        }
        else 
        {
            return Notification::send($user, new $noticeName( $data, $data_old ));   
        }

    }
    
}



?>