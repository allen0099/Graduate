<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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
