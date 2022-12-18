<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Tag extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $fillable = ['name','slug'];

    
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
