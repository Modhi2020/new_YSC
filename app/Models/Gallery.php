<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['album_id','image','size','type','link'];

    public function album()
    {
        return $this->belongsTo(App\Models\Album::class);
    }
}
