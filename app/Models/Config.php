<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    public static function getOneSetPriceValue()
    {
        return Config::where('key', 'one_set_price')->first()->value;
    }

    public static function getReturnLocation()
    {
        return Config::where('key', '歸還地點')->first();
    }

    public static function getReturnLocationValue()
    {
        return Config::where('key', '歸還地點')->first()->value;
    }
}
