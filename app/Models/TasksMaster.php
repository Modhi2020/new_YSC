<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class TasksMaster extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','details','results'];
    protected $table = 'tasks_masters';
    protected $guarded=[];

    public function taskstates()
    {
        return $this->belongsTo('App\Models\TaskState','state');
    }

    public function taskdegrees()
    {
        return $this->belongsTo('App\Models\TaskDegree','degree');
    }

    public function supervisors()
    {
        return $this->belongsTo('App\Models\User','supervisor_id');
    }

    public function agrees()
    {
        return $this->belongsTo('App\Models\Agree','agree');
    }

    public function taskstypes()
    {
        return $this->belongsTo('App\Models\TasksType','type');
    }

}
