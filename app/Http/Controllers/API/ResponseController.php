<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ResponseController extends Controller
{
    /**
     * @param $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($response): \Illuminate\Http\JsonResponse
    {
        return response()->json($response, 200);
    }

    /**
     * @param $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $code = 404): \Illuminate\Http\JsonResponse
    {
    	$response = [
            'error' => $error,
        ];
        return response()->json($response, $code);
    }
}
