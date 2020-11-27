<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'accessory_id');
    }
}
