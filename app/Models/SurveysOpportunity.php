<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveysOpportunity extends Model
{
    use HasFactory;
    protected $table = 'surveys_opportunities';
    protected $guarded=[];
}
