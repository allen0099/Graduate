<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'accessory',
        'cloth',
        'student',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'returned' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'order_id',
        'student_id',
        'color_item',
        'size_item',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\User', 'student_id');
    }

    public function accessory()
    {
        return $this->belongsTo('App\Models\Item', 'color_item');
    }

    public function cloth()
    {
        return $this->belongsTo('App\Models\Item', 'size_item');
    }
}
