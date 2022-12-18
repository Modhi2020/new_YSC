<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomingsGreetines extends Model
{
    use HasFactory;
    protected $table = 'outcomings_greetiness';
    protected $guarded=[];

    public function tosides()
    {
        return $this->belongsTo('App\Models\OutgoingSide','to_side_id');
    }
}
