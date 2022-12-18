<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    use HasFactory;
    protected $table = 'task_files';
    public $fillable= ['filename','imageable_id','type'];

    // public function imageable()
    // {
    //     return $this->morphTo();
    // }
}
