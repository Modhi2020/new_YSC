<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class IncentivesSanctionsMas extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['description'];
    protected $table = 'incentives_sanctions_mas';
    protected $guarded=[];

    public function incentivesTypes()
    {
        return $this->belongsTo('App\Models\IncentivesType','type');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

}
