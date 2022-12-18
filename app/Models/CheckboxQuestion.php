<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class CheckboxQuestion extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['questions','first_answer','second_answer','third_answer','fourth_answer'];
    protected $table = 'checkbox_questions';
    protected $guarded=[];
}
