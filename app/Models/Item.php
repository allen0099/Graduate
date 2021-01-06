<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    const BACHELOR = '學士';
    const MASTER = '碩士';
    const DOCTOR = '博士';


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'remain_quantity',
        'request_quantity',
    ];

    public function getRemainQuantityAttribute()
    {
        if (OrderItem::where('item_id', $this->id)->count() > 0) {
            // todo: check returned items
            $ordered_sum = OrderItem::where('item_id', $this->id)
                ->get()
                ->map->only('quantity')
                ->flatten()
                ->sum();
            return $this->quantity - $ordered_sum;
        }
        return $this->quantity;
    }

    public function getRequestQuantityAttribute()
    {
        if ($this->pivot !== null) {
            return $this->pivot->quantity;
        }
        return null;
    }

    public function Orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items')
            ->as('orders');
    }
}
