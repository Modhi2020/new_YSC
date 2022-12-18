<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class IncentivesType extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;

    public $translatable = ['name'];
    protected $table = 'incentives_types';
    protected $fillable = ['name'];
}
