<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const code_created = 1; // 訂單成立 尚未繳費
    const code_paid = 2; // 　　　　 完成繳費 尚未領取衣服
    const code_received = 3; // 　　　　 　　　　 完成領取衣服 尚未歸還衣服
    const code_returned = 4; // 　　　　 　　　　 　　　　　　 完成歸還衣服 完成歸還保證金
    const code_requestCancel = 5; // 已申請訂單取消
    const code_canceled = 6; // 已取消訂單

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'owner',
        'sets',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function sets()
    {
        return $this->hasMany('App\Models\Set');
    }
}
