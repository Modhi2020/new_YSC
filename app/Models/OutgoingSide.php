<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class OutgoingSide extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $table = 'outgoing_sides';
    protected $fillable = ['name','slug','image','side_id','type','state'];
}
