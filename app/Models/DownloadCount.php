<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadCount extends Model
{
    use HasFactory;
    protected $table = 'download_counts';
    protected $fillable = ['name','counters'];
}
