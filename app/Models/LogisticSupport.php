<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class LogisticSupport extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;

    public $translatable = ['name'];
    protected $table = 'logistic_supports';
    protected $fillable = ['name','ready','select'];
}
