<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Opportunity extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    
    public $translatable = ['title','details'];
    protected $table = 'opportunities';
    protected $guarded=[];

    
    public function locations()
    {
        return $this->belongsTo('App\Models\City','location_id');
    }

    public function cities()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }

}
