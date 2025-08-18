<?php

namespace App\helpers;

use Illuminate\Support\Facades\Log as LaravelLog;

class LogConsole
{
    public static function browser($message, $data): void
    {
        // Log to Laravel's log file
        LaravelLog::info('Browser Log:', [
            'message' => $message,
            'data' => $data
        ]);

        // Only output to console in local environment
        if (app()->environment('local')) {
            $jsonMessage = json_encode($message);
            $jsonData = json_encode($data);
            $output = "<script>if (typeof console !== 'undefined') console.log(" . $jsonMessage . ", " . $jsonData . ");</script>";

            // Buffer the output to prevent headers already sent error
            if (!headers_sent()) {
                echo $output;
            }
        }
    }
}
