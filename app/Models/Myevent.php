<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Myevent extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;

    public $translatable = ['title','details'];
    protected $table = 'myevents';
    protected $guarded=[];

    public function cities()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','type');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function images()
    {
        return $this->morphMany('App\Models\MediaFile', 'imageable');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function rating()
    {
        return $this->hasMany('App\Models\Rating', 'property_id');
    }
    
    // public function images()
    // {
    //     return $this->hasMany('App\Models\MediaFile','id');
    // }


    public function image()
    {
        return $this->belongsTo('App\Models\MediaFile','id','imageable_id');
    }
}
