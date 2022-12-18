<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Beneficiary extends Model
{
    use HasFactory;
    protected $table = 'beneficiarys';
    protected $guarded=[];
}
