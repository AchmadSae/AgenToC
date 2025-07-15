<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Carbon\Carbon;

class GenerateId
{
    /**
     * Generate a unique user_detail_id format: string+date(exlude years)
     * @return string 
     * @param string $prefix
     */

    public static function generateId(string $prefix = '', bool $isDate): string
    {
        $random = rand(1000, 9999);
        if (!$isDate) {
            return $prefix . '-' . $random;
        }
        $date = Carbon::now()->format('dm');

        return $prefix . '-' . $random . '-' . $date;
    }

    /**
     * ID with with "-" for slug
     **/

    public static function generateSlug(string $title): string
    {
        return Str::slug($title, '-');
    }
}
