<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class TasksDetail extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;    
    public $translatable = ['com_results'];
    protected $table = 'tasks_details';
    protected $guarded=[];

    public function tasks()
    {
        return $this->belongsTo('App\Models\TasksMaster','task_id');
    }

    public function commissioners()
    {
        return $this->belongsTo('App\Models\User','commissioner_id');
    }

    public function agrees()
    {
        return $this->belongsTo('App\Models\Agree','agree');
    }

    public function remindernotifications()
    {
        return $this->belongsTo('App\Models\ReminderNotification','repeat_id');
    }
}
