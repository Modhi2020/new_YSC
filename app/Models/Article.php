<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Article extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','details'];
    protected $table = 'articles';
    protected $guarded=[];

    public function authors()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','type');
    }

    public function images()
    {
        return $this->belongsTo('App\Models\ArticlesImage','id','imageable_id');
    }

    
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function rating()
    {
        return $this->hasMany('App\Models\Rating', 'property_id');
    }



}
