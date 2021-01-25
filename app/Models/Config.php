<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function editSetPrice($cloth, int $price)
    {
        if ($cloth === 'bachelor') {
            $c = Config::getBachelorSetPrice();
        } else if ($cloth === 'master') {
            $c = Config::getMasterSetPrice();
        } else {
            return abort(404);
        }

        $c->value = $price;
        $c->save();

        return $c;
    }

    public static function getBachelorSetPrice()
    {
        return Config::where('key', 'bachelor_set_price')->first();
    }

    public static function getBachelorSetPriceValue()
    {
        return Config::where('key', 'bachelor_set_price')->first()->value;
    }

    public static function getMasterSetPrice()
    {
        return Config::where('key', 'master_set_price')->first();
    }

    public static function getMasterSetPriceValue()
    {
        return Config::where('key', 'master_set_price')->first()->value;
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
