<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Punishment extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name','description'];
    protected $table = 'punishments';
    protected $guarded=[];
}
