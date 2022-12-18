<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EscapeUniCodeJson;

class BeneficiarysOpportunity extends Model
{
    use HasFactory;
    use EscapeUniCodeJson;
    protected $table = 'beneficiarys_opportunities';
    protected $guarded=[];
}
