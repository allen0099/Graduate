<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function Orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_items')
            ->as('orders');
    }

    public function Remain()
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
}
