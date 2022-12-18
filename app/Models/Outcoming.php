<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Outcoming extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;

    public $translatable = ['title','details'];
    protected $table = 'outcomings';
    protected $guarded=[];

    public function incomings()
    {
        return $this->belongsTo('App\Models\Incoming','incoming_id');
    }

    // public function insides()
    // {
    //     return $this->belongsTo('App\Models\OutgoingSide','from_side_id');
    // }

    public function tosides()
    {
        return $this->belongsTo('App\Models\OutgoingSide','to_side_id');
    }

    public function diarys()
    {
        return $this->belongsTo('App\Models\Diary','type');
    }
}
