<?php 

namespace App\Traits;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Add_notice;
use App\Notifications\Subjects\update_subject;
use App\Notifications;
use Auth;

/**
 * 
 */
Trait showNotificationTrait
{
    public function showNotificationTrait($routeName = null, $id = null)
    {
        $noticeId = auth()->user()->unreadNotifications()->where("notifications.data->route",$routeName)
        ->where('notifications.data->id',$id)->first();
       
        if($noticeId)
        {
           return $noticeId->markAsRead(); 
        }
    
    }
    
}

?>