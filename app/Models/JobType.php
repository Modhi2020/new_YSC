<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class JobType extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    
    public $translatable = ['name'];
    protected $table = 'job_types';
    protected $fillable = ['name'];
}
