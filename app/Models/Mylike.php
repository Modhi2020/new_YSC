<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mylike extends Model
{
    use HasFactory;
    protected $table = 'mylikes';
    protected $guarded=[];

    public function likeable()
    {
        return $this->morphTo();
    }
    
}
