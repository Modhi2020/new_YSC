<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Incoming extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;

    public $translatable = ['title','details'];
    protected $table = 'incomings';
    protected $guarded=[];

    public function outcomings()
    {
        return $this->belongsTo('App\Models\Outcoming','outcoming_id');
    }

    public function fromsides()
    {
        return $this->belongsTo('App\Models\OutgoingSide','from_side_id');
    }

    // public function outgoingsides()
    // {
    //     return $this->belongsTo('App\Models\OutgoingSide','to_side_id');
    // }

    public function diarys()
    {
        return $this->belongsTo('App\Models\Diary','type');
    }
}
