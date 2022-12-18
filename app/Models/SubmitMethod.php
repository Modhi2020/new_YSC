<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class SubmitMethod extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $table = 'submit_methods';
    protected $fillable = ['name'];
}
