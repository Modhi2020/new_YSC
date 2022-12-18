<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\EscapeUniCodeJson;

class Preacher extends Model
{
    use HasTranslations;
    use EscapeUniCodeJson;
    public $translatable = ['name'];
    protected $table = 'preachers';
    protected $fillable = ['name','email','phone','type','notes'];

    public function jobTypes()
    {
        return $this->belongsTo('App\Models\JobType','type');
    }

}
