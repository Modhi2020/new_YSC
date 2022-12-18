<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class UserType extends Model
{
    use HasFactory;
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $table = 'user_types';
    protected $fillable = ['name','roles_name'];
}
