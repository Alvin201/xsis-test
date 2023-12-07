<?php

namespace App\Helper;
use Illuminate\Validation\ValidationException;


class GlobalResponse
{

    public static function sendResponse($code,$message, $total, $data, $status = 200)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'total' => $total,
            'data' => $data
        ];
        return response()->json($response, $status);
    }

    // public static function sendSuccess($code,$message, $status = 200)
    // {
    //     $response = [
    //         'code' => $code,
    //         'message' => $message
    //     ];
    //     return response()->json($response, $status);
    // }

    public static function customJsonResponseValidation($code,$message,$data = [], $status = 400)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'valid' => $data
        ];
        return response()->json($response, $status);
    }

    public static function GlobalJsonResponse($code,$message, $status)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'status' => $status
        ];
        return response()->json($response, $status);
    }

    public static function customJsonResponse($code, $message, $data = [], $status = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

?>
