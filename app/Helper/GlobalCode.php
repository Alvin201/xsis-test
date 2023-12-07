<?php

namespace App\Helper;
use Illuminate\Validation\ValidationException;


class GlobalCode
{
    public static function getCodeInvalid()
    {
        $code = "M3124";
        return $code;
    }

    public static function getCodeNotExists()
    {
        $code = "M3123";
        return $code;
    }

    public static function getCodeUnmatch()
    {
        $code = "M3122";
        return $code;
    }


    public static function getCodeOTPExp()
    {
        $code = "M3121";
        return $code;
    }


    public static function getCodeValidation()
    {
        $code = "M3120";
        return $code;
    }


    public static function getCodeDeactive()
    {
        $code = "M5001";
        return $code;
    }

    public static function getCodeOK()
    {
        $code = "M0000";
        return $code;
    }


    public static function getCodeError()
    {
        $code = "M4000";
        return $code;
    }
}
