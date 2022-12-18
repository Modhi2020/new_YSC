<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;


class SubmissionForm extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name','descriptions'];
    protected $table = 'submission_forms';
    protected $guarded=[];
}
