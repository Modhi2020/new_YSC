<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Post extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['title','body'];
    protected $table = 'posts';
    protected $fillable = ['user_id','title','slug','image','path','body','view_count','status','is_approved'];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public static function archives()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
                    ->groupBy('year','month')
                    ->orderByRaw('min(created_at) desc')
                    ->get()
                    ->toArray();
    }

    public function approveds()
    {
        return $this->belongsTo('App\Models\PostApproved', 'is_approved');
    }

    public function statuss()
    {
        return $this->belongsTo('App\Models\PostStatu', 'status');
    }
}
