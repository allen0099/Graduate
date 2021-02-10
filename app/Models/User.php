<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const ADMIN = 'admin';
    const STUDENT = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'class_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'class_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'school_class.department',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'filled_pay_form' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function isRole(string $role)
    {
        if (in_array($role, [User::ADMIN, User::STUDENT]))
            if ($this->role === $role) {
                return true;
            }
        return false;
    }

    public function isBachelor()
    {
        return str_starts_with($this->username, '2') || str_starts_with($this->username, '4') ?
            true : false;
    }

    public function isMaster()
    {
        return str_starts_with($this->username, '6') || str_starts_with($this->username, '7') ?
            true : false;
    }

    public function school_class()
    {
        return $this->belongsTo('App\Models\DepartmentClass', 'class_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'owner_id');
    }

    public function set()
    {
        return $this->hasOne('App\Models\Set', 'student_id');
    }
}
