<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Slider extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','description'];
    protected $fillable = ['title','description','image','path'];
}
