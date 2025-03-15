<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseFormatterController extends Controller
{
    public static $response = [
        'status' => 'success',
        'message' => null,
        'data' => null,
    ];

    public static function success($data = null, $message = null, $code = 200)
    {
        self::$response['data'] = $data;
        self::$response['message'] = $message;

        return response()->json(self::$response, $code);
    }

    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['status'] = 'error';
        self::$response['data'] = $data;
        self::$response['message'] = $message;

        return response()->json(self::$response, $code);
    }
}
