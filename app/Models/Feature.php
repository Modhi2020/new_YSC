<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Feature extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $fillable = ['name','slug'];

    
    public function properties()
    {
        return $this->belongsToMany(Property::class)->withTimestamps();
    }
}
