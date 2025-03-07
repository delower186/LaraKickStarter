<?php
namespace App\Tools;

class Response{
    public static function success($message="Success",$data = [], $success=true, $status = 200)
    {
        return response()->json([
            "success"=> $success,
            "message" => $message,
            "data" => $data
        ], $status);
    }

    public static function error($message="Error",$data = [], $status = 500, $success=false)
    {
        return response()->json([
        "success"=> $success,
        "message" => $message,
        "data"=> $data
        ],$status);
    }
}
