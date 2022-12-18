<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class TaskDegree extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $table = 'task_degrees';
    protected $fillable = ['name'];
}
