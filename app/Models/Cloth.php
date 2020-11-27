<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cloth extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'cloth_id');
    }
}
