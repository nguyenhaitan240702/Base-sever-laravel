<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Common
{
    public static function cryptData($data): string
    {
        return base64_encode($data);
    }
    public static function decryptData($data)
    {
        return base64_decode($data);
    }
    public static function hashUnique($email): string
    {
        $date = Carbon::now(config('app.timezone'));
        $expiredDate = $date->addDays(config('settings.token_register_expired_date')); // ExpireDate 2 day
        $token = $expiredDate . 'andemail' . $email;
        return Crypt::encrypt($token);
    }
    public static function hashValid($email): string
    {
        $date = Carbon::now(config('app.timezone'));
        $expiredDate = $date->addDays(config('settings.token_forgot_expired_date')); // ExpireDate 2 day
        $token = $expiredDate . 'andemail' . $email;
        return Crypt::encrypt($token);
    }
    public static function hashValue($id): string
    {
        $date = Carbon::now(config('app.timezone'));
        $current_date = $date->toDateTimeString();
        $current_date = strtotime($current_date);
        $hash = $current_date . $id;
        return Hash::make($hash);
    }
    public static function convertStringToArray($string)
    {
        if (empty($string)) {
            return false;
        }
        return explode('andemail', $string);
    }
    public static function limitWord($word, $limit = 10, $dotted = '...'): string
    {
        return Str::words($word, $limit, $dotted);
    }
    public static function formatPrice($price, $decimals = 0, $dec_point = ".", $thousands_sep = ",")
    {
        if (!is_numeric($price)) {
            return false;
        }
        $price = intval($price);
        return number_format($price, $decimals, $dec_point, $thousands_sep);
    }
    public static function checkNotifyNew($datetime): string
    {
        $current_date = Carbon::now(config('app.timezone'))->format('Y-m-d');
        $datetime = Carbon::parse($datetime)->format('Y-m-d');
        $cacl = strtotime($current_date) - strtotime($datetime);
        $day = $cacl / 3600 / 24;
        if ($day <= 7) {
            return 'NEW';
        }
        return '';
    }
    public static function randomString($length = 10, $isNumber = false): string
    {
        $characters = '0123456789abcdefghilkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($isNumber) {
            $characters = '0123456789';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function checkRegex($regex, $value): bool
    {
        $len = mb_strlen($value, 'UTF-8');
        for ($i = 0; $i < $len; $i++) {
            $characters = mb_substr($value, $i, 1, 'UTF-8');
            if (!preg_match($regex, $characters)) {
                return false;
            }
        }
        return true;
    }
}
