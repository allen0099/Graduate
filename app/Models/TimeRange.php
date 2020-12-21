<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeRange extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'content',
        'start_time',
        'end_time',
    ];
}
