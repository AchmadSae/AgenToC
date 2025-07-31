<?php

namespace App\Helpers;

class Log
{
    public static function browser($message, $data): void
    {
          $jsonMessage = json_encode($message);
          $jsonData = json_encode($data);
          echo "<script>console.log(" . $jsonMessage . " + ' = ' + " . $jsonData . ");</script>";
    }
}
