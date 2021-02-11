<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Config extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function editSetPrice($type, int $price)
    {
        if ($type === 'bachelor') {
            $t = Config::getBachelorPrice();
        } else if ($type === 'master') {
            $t = Config::getMasterPrice();
        } else if ($type === 'bachelor_margin') {
            $t = Config::getBachelorMarginPrice();
        } else if ($type === 'master_margin') {
            $t = Config::getMasterMarginPrice();
        } else {
            return abort(404);
        }

        $t->value = $price;
        $t->save();

        return $t;
    }

    public static function getBachelorSetPriceValue()
    {
        $price = Config::where('key', 'bachelor_price')->first()->value +
            Config::where('key', 'bachelor_margin_price')->first()->value;

        return $price;
    }

    public static function getMasterSetPriceValue()
    {
        $price = Config::where('key', 'master_price')->first()->value +
            Config::where('key', 'master_margin_price')->first()->value;

        return $price;
    }

    public static function getBachelorPrice()
    {
        return Config::where('key', 'bachelor_price')->first();
    }

    public static function getMasterPrice()
    {
        return Config::where('key', 'master_price')->first();
    }

    public static function getBachelorMarginPrice()
    {
        return Config::where('key', 'bachelor_margin_price')->first();
    }

    public static function getMasterMarginPrice()
    {
        return Config::where('key', 'master_margin_price')->first();
    }

    public static function getReturnLocation()
    {
        return Config::where('key', '歸還地點')->first();
    }

    public static function getReturnLocationValue()
    {
        return Config::where('key', '歸還地點')->first()->value;
    }

    public static function getDepartmentStamp()
    {
        return Config::where('key', 'department_stamp')->first();
    }

    public static function getDepartmentStampUrl()
    {
        $filename = Config::where('key', 'department_stamp')->first()->value;
        $disk = Storage::disk('picture');

        return $disk->exists($filename)
            ? $disk->url($filename)
            : null;
    }

    public static function getDepartmentStampFilename()
    {
        $filename = Config::where('key', 'department_stamp')->first()->value;
        $disk = Storage::disk('picture');

        return $disk->exists($filename)
            ? $filename
            : null;
    }
}
