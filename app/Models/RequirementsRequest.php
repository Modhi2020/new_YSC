<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class RequirementsRequest extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','details'];
    protected $table = 'requirements_request';
    protected $guarded=[];

    public function directorates()
    {
        return $this->belongsTo('App\Models\Directorate','directorate_id');
    }

    public function regions()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function requirementsTypes()
    {
        return $this->belongsTo('App\Models\RequirementsType','type');
    }

    public function mosques()
    {
        return $this->belongsTo('App\Models\Mosque','mosque_id');
    }
}
