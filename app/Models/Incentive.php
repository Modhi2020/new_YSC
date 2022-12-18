<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Incentive extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name','description'];
    protected $table = 'incentives';
    protected $guarded=[];
}
