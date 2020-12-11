<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const code_0 = 0; // 已結案訂單
    const code_1 = 1; // 訂單成立 尚未繳費
    const code_2 = 2; // 　　　　 完成繳費 尚未領取衣服
    const code_3 = 3; // 　　　　 　　　　 完成領取衣服 尚未歸還衣服
    const code_4 = 4; // 　　　　 　　　　 　　　　　　 完成歸還衣服 完成歸還保證金
    const code_10 = 10; // 簽歸還切結書、收取賠償金、開立收據
    const code_50 = 50; // 尚未退款
    const code_51 = 51; // 退款完成
    const code_100 = 100; // 已取消訂單

    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cloth()
    {
        return $this->belongsTo('App\Models\Cloth');
    }

    public function accessory()
    {
        return $this->belongsTo('App\Models\Accessory');
    }
}
