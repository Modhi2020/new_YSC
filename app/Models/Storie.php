<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Storie extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','details'];
    protected $table = 'stories';
    protected $guarded=[];

    public function services()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category','type');
    }
}
