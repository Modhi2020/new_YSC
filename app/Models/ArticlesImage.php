<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesImage extends Model
{
    use HasFactory;
    protected $table = 'articals_images';
    public $fillable= ['filename','imageable_id','subart_id','type','page','path'];
}
