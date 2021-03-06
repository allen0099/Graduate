<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldClass extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'department_id',
        'class_name',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'old_classes';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'department_id',
    ];

    public function students()
    {
        return $this->hasMany('App\Models\User', 'class_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
}
