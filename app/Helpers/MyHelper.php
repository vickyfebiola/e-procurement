<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class MyHelper
{
    /**
     * Generate UUID
     *
     * @return string
     */
    public static function generateUuid()
    {
        return (string) Str::uuid();
    }

    /**
     * Generate ID with random capitalized alphabets and integers
     *
     * @param string $prefix
     * @param int $length
     * @return string
     */
    public static function generateId(string $prefix = 'ID-', int $length = 12)
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix ? $prefix . $randomString : $randomString;
    }
}
