<?php

/*
 * Global helpers file with misc functions.
 */

use Illuminate\Support\Facades\Log;

if (! function_exists('writeToLog')) {

    /**
     * Write custom messages to Log
     *
     * @param $logMessage
     * @param string $logType
     * @return \Illuminate\Config\Repository|mixed
     */
    function writeToLog($logMessage, $logType = 'error')
    {
        try {
            $allLogTypes = ['alert', 'critical', 'debug', 'emergency', 'error', 'info','notice'];

            $logType = strtolower($logType);

            if (in_array($logType, $allLogTypes)) {
                Log::$logType($logMessage);
            }
        } catch (Exception $exception) {
            //
        }
    }
}
