<?php

namespace App\Models;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EscapeUniCodeJson;

class Category extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $fillable = ['name','slug','image'];


    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
