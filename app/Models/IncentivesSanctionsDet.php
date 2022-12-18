<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class IncentivesSanctionsDet extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['description'];
    protected $table = 'incentives_sanctions_dets';
    protected $guarded=[];

    public function incentivesSanctions()
    {
        return $this->belongsTo('App\Models\IncentivesSanctionsMas','inc_san_id');
    }

    public function tasks()
    {
        return $this->belongsTo('App\Models\TasksMaster','task_id');
    }

    public function incentives()
    {
        return $this->belongsTo('App\Models\Incentive','incentive_id');
    }

    public function punishments()
    {
        return $this->belongsTo('App\Models\Punishment','punishment_id');
    }
}
