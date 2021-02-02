<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeRange extends Model
{
    use HasFactory;

    const BORROW_TIME = 1;
    const PAID_TIME = 2;
    const B = 3;
    const M = 4;
    const RET = 5;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

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

    public static function getBachelorReturnStartTime()
    {
        return TimeRange::find(TimeRange::B)->start_time;
    }

    public static function getMasterReturnStartTime()
    {
        return TimeRange::find(TimeRange::M)->start_time;
    }
}
