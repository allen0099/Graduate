<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    const code_created = 1; // 訂單成立 尚未繳費
    const code_paid = 2; // 完成繳費 尚未領取衣服
    const code_received = 3; // 完成領取衣服 尚未歸還衣服
    const code_returned = 4; // 完成歸還衣服 未還款
    const code_refunded = 5; // 已還款 而且上鎖
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

    public static function createDocumentId()
    {
        // todo: replace with document id generate method
        return now()->format('Ymdhis') . str_pad(rand($min = 0, $max = 99999), 5, '0', STR_PAD_LEFT);
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function sets()
    {
        return $this->hasMany('App\Models\Set')->withTrashed();
    }
}
