<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    protected function success(object|array $data=null, string $message=null, bool $status=true): JsonResponse
    {
        $responses = [
            'success' => $status,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($responses, Response::HTTP_OK);
    }

    protected function failed(string $message=null, bool $status=false): JsonResponse
    {
        $responses = [
            'success' => $status,
            'message' => $message
        ];

        return response()->json($responses, Response::HTTP_BAD_REQUEST);
    }

}
