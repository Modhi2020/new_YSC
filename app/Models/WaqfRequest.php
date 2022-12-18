<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class WaqfRequest extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','details'];
    protected $table = 'waqf_requests';
    protected $guarded=[];

    public function directorates()
    {
        return $this->belongsTo('App\Models\Directorate','directorate_id');
    }

    public function regions()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function waqfTypes()
    {
        return $this->belongsTo('App\Models\WaqfType','type_id');
    }
}