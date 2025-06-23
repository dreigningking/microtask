<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'value'];

    public static function getValue($name, $default = null)
    {
        $setting = static::where('name', $name)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($name, $value)
    {
        return static::updateOrCreate(['name' => $name], ['value' => $value]);
    }
}
