<?php

namespace App\Helpers;

class Log
{
    public static function browser($data, $message)
    {
        $jsonData = json_encode($data);
        echo "<script>console.log(" . $message . '= ' . $jsonData . ");</script>";
    }
}
