<?php namespace Danj\Traffic\Helpers;

class TimeHelper
{
    /**
     * Outputs the time in a human readable format
     * @param int $seconds
     * @return string
     */
    public function niceTime($seconds)
    {
        $mins = self::secToMin($seconds);
        if ($mins > 60) {
            return self::secToHour($seconds) . " hours " . self::secToRemainingMins($seconds) . " mins";
        } else {
            return $mins . " mins";
        }
    }

    /**
     * Converts seconds to minutes
     * @param int $seconds
     * @return int
     */
    public static function secToMin($seconds)
    {
        return floor(
            $seconds / 60
        );
    }

    /**
     * Converts seconds to hours
     * @param int $seconds
     * @return int
     */
    public static function secToHour($seconds)
    {
        return floor(
            self::secToMin($seconds) / 60
        );
    }

    /**
     * Gets the remainder of minutes after hours has been calculated
     * @param int $seconds
     * @return int
     */
    public static function secToRemainingMins($seconds)
    {
        return floor(
            self::secToMin($seconds) % 60
        );
    }
}
