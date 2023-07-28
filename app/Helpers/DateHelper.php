<?php

namespace App\Helpers;

use Carbon\Carbon;
use Spatie\Period\Period;

class DateHelper
{
    // you can write more functions here
    public static function formatDate($datetime)
    {
        if ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d');
            // output: 2023-07-27
        }
        return false;
    }
    public static function formatDateTime($datetime)
    {
        if ($datetime) {
            return Carbon::parse($datetime)->format('Y-m-d H:i:s');
            // output: 2023-07-27 00:00:00
        }
        return false;
    }
    public static function ISO8601Format($datetime)
    {
        if ($datetime) {
            return Carbon::parse($datetime)->toIso8601String();
            // Output: "2023-07-27T10:30:00+00:00"
        }
        return false;
    }
    public static function RFC2822Format($datetime)
    {
        if ($datetime) {
            return Carbon::parse($datetime)->format('r');
            // Output: "Thu, 27 Jul 2023 10:30:00 +0000"
        }
        return false;
    }
    public static function timestampFormat($datetime)
    {
        if ($datetime) {
            return Carbon::parse($datetime)->timestamp;
            // Output: 1674821400
        }
        return false;
    }
    public static function diffForHuman($datetime)
    {
        if ($datetime) {
            return Carbon::parse($datetime)->diffForHumans();
            // Output: "2 days ago"
        }
        return false;
    }
    public static function daysOfInterval($startDate, $endDate)
    {
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            return $startDate->diffInDays($endDate) + 1;
            // Output: 31
        }
        return false;
    }
    public static function hoursOfInterval($startDate, $endDate)
    {
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            return $startDate->diffInHours($endDate);
            // Output: 24
        }
        return false;
    }
    public static function diffDaysFromNow($datetime)
    {
        if ($datetime) {
            $date = Carbon::parse($datetime);
            $daysDifference = $date->diffInDays(Carbon::now());
            if($date->isPast()){
                return -$daysDifference;
                // day in the past
            } else {
                return $daysDifference;
                //  day in the future or today.
            }
        }
        return false;
    }
}
