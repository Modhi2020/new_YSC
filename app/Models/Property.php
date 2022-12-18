<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Property extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title'];

    protected $fillable = [
        'title',    'price',        'featured',     'purpose',  'type', 
        'slug',     'bedroom',      'bathroom',     'city',     'city_slug',    'address',
        'area',     'agent_id',     'description',  'video',    'floor_plan',   
        'location_latitude',        'location_longitude',       'nearby',
        
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','agent_id');
    }

    public function gallery()
    {
        return $this->hasMany(PropertyImageGallery::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function rating()
    {
        return $this->hasMany('App\Models\Rating', 'property_id');
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function latestImage()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function PropertyTypes()
    {
        return $this->belongsTo('App\Models\PropertyType','type');
    }

    public function PropertyPurposes()
    {
        return $this->belongsTo('App\Models\PropertyPurpose','purpose');
    }

}
