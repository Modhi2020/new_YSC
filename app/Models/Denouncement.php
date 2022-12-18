<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Denouncement extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','details'];
    protected $table = 'denouncements';
    protected $guarded=[];

    public function directorates()
    {
        return $this->belongsTo('App\Models\Directorate','directorate_id');
    }

    public function regions()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function complaints()
    {
        return $this->belongsTo('App\Models\Complaint','complaint_id');
    }

    public function denouncementTypes()
    {
        return $this->belongsTo('App\Models\DenouncementType','type');
    }
}
