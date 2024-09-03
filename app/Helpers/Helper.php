<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function generate_unique_code($table, $column, $length = 8)
    {
        // $code = Str::random($length);

        // while (self::is_duplicate_code($table, $column, $code)) {
        //     $code = Str::random($length);
        // }

        // return $code;
        $characters = '0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        while (self::is_duplicate_code($table, $column, $code)) {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[mt_rand(0, strlen($characters) - 1)];
            }
        }

        return $code;
    }

    public static function is_duplicate_code($table, $column, $code)
    {
        return DB::table($table)->where($column, $code)->exists();
    }
}
