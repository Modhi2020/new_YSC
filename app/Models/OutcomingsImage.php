<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomingsImage extends Model
{
    use HasFactory;
    protected $table = 'outcomings_images';
    public $fillable= ['filename','imageable_id','type','page'];
}
