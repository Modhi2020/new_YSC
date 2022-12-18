<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;
    protected $table = 'student_answers';
    protected $guarded=[];

    public function students()
    {
        return $this->belongsTo('App\Models\User', 'student_id');
    }

    public function opportunities()
    {
        return $this->belongsTo('App\Models\Opportunity','opportunity_id');
    }
}
