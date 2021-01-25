<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeRange extends Model
{
    use HasFactory;

    const B = 5;
    const M = 6;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'content',
        'start_time',
        'end_time',
    ];

    public static function getBachelorReturnEndTime()
    {
        return TimeRange::find(TimeRange::B)->end_time;
    }

    public static function getMasterReturnEndTime()
    {
        return TimeRange::find(TimeRange::M)->end_time;
    }
}
