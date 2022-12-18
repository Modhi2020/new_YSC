<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Contact extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['address'];
    protected $table = 'contacts';
    protected $guarded=[];

    public function cities()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }
}
