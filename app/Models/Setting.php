<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
        $fromCache = Cache::get('setting_' . $key);
        if ($fromCache) return $fromCache;
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

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $key = $this->attributes['key'] ?? null;
        if ($key && $value) Cache::forever('setting_' . $key, $value);

        $this->attributes['value'] = $value;
    }

    /**
     * @return bool|null
     * @throws Exception
     */
    public function delete()
    {
        $key = $this->attributes['key'] ?? null;
        if ($key) Cache::forget('setting_' . $key);

        return parent::delete();
    }
}
