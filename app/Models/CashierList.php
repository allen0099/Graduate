<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierList extends Model
{
    use HasFactory;

    const CODE_1 = 1; // 已建立批次
    const CODE_2 = 2; // (請款中) 送出出納組
    const CODE_3 = 3; // (已退款) 出納組完成

    const CODE_ARRAY = [self::CODE_1, self::CODE_2, self::CODE_3];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lists';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'sets'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'lock' => 'boolean',
    ];

    public function sets()
    {
        return $this->hasMany('App\Models\Set', 'list_id');
    }
}
