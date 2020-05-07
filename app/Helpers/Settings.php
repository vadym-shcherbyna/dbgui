<?php

namespace App\Helpers;

use App\Setting;

class Settings {

    /**
     * Settings array
     *
     * @var array
     */
    public static $settings = [];

    /**
     * Get setting value by code
     *
     * @param string $code
     *
     * @return mix
     */
    public static function get ($code)
    {
        if (empty(Settings::$settings)) {
            Settings::$settings =  Setting::all();

            foreach (self::$settings  as $setting) {

                switch ($setting->type) {
                    case 'flag':
                        $value =  ($setting->value) ? 1 : 0;
                        break;
                    case 'integer':
                        $value =  (int) $setting->value;
                        break;
                    case 'string':
                        $value =  $setting->value;
                        break;
                    default:
                        $value  =  $setting->value;
                        break;
                }

                Settings::$settings [$setting->code] = $value;
            }
        }

        if (isset(Settings::$settings [$code])) {
            return Settings::$settings [$code];
        } else {
            return  false;
        }
    }
}
