<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Testimonial extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name','testimonial'];
    protected $fillable = ['name','image','path','testimonial','slug','status'];
}
