<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Library extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;

    public $translatable = ['title','details'];
    protected $table = 'libraries';
    protected $guarded=[];

    public function authors()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }

    public function services()
    {
        return $this->belongsTo('App\Models\Service','service_id');
    }
}
