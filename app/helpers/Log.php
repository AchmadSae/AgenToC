<?php

namespace App\Helpers;

class Log
{
    public static function browser($data)
    {
        $jsonData = json_encode($data);
        echo "<script>console.log(" . $jsonData . ");</script>";
    }
}
