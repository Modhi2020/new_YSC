<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class DenouncementType extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $table = 'denouncement_types';
    protected $fillable = ['name'];
}
