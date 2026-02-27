<?php

namespace App\Helpers;

class UserAgentHelper
{
    public static function parse($userAgent)
    {
        // Default values
        $browser = "Unknown Browser";
        $os = "Unknown OS";
        $device = "Desktop";

        // --- Detect browser ---
        if (stripos($userAgent, 'Chrome') !== false) $browser = "Chrome";
        elseif (stripos($userAgent, 'Firefox') !== false) $browser = "Firefox";
        elseif (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false) $browser = "Safari";
        elseif (stripos($userAgent, 'Edge') !== false) $browser = "Edge";
        elseif (stripos($userAgent, 'OPR') !== false || stripos($userAgent, 'Opera') !== false) $browser = "Opera";

        // --- Detect OS ---
        if (stripos($userAgent, 'Windows NT 10.0') !== false) $os = "Windows 10";
        elseif (stripos($userAgent, 'Windows NT 11.0') !== false) $os = "Windows 11";
        elseif (stripos($userAgent, 'Windows NT 6') !== false) $os = "Windows";
        elseif (stripos($userAgent, 'Macintosh') !== false) $os = "MacOS";
        elseif (stripos($userAgent, 'Linux') !== false) $os = "Linux";
        elseif (stripos($userAgent, 'Android') !== false) $os = "Android";
        elseif (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) $os = "iOS";

        // --- Detect device type ---
        if (stripos($userAgent, 'Mobile') !== false) $device = "Mobile";
        elseif (stripos($userAgent, 'Tablet') !== false) $device = "Tablet";
        else $device = "Desktop";

        return "$browser on $os — $device";
    }
}