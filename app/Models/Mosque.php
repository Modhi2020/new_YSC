<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Mosque extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    
    public $translatable = ['name','address','contents'];
    protected $table = 'mosques';
    protected $guarded=[];

    public function directorates()
    {
        return $this->belongsTo('App\Models\Directorate','directorate_id');
    }

    public function regions()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function logisticSupports()
    {
        return $this->belongsTo('App\Models\LogisticSupport','logistic_id');
    }

    public function preachers()
    {
        return $this->belongsTo('App\Models\Preacher','preacher_id');
    }

    public function leaders()
    {
        return $this->belongsTo('App\Models\Preacher','leader_id');
    }

    public function muezzins()
    {
        return $this->belongsTo('App\Models\Preacher','muezzin_id');
    }
}
