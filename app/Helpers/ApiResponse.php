<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function sendResponse($resp, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $resp
        ];

        return response()->json($response, $code);
    }

    public static function throw($e, $message = "Something went wrong!")
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }
}
