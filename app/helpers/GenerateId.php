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

    public static function generateWithDate(string $prefix = ''): string
    {
        $random = strtoupper(Str::random(4));
        $date = Carbon::now()->format('dm');

        return $prefix . '-' . $random . '-' . $date;
    }
}
