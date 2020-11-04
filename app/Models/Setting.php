<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed value
 * @property string key
 * @property string title
 * @property mixed additional
 */
class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'title',
        'additional',
    ];

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $key
     * @return Setting|Builder|Model|object|null
     */
    public static function getByKey(string $key)
    {
        return self::query()->where('key', $key)->first();
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function getValue(string $key, $default = null)
    {
        $item = self::getByKey($key);
        return ($item ? $item->value : $default);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function getAdditional(string $key)
    {
        $item = self::getByKey($key);
        return ($item ? $item->additional : null);
    }
}
