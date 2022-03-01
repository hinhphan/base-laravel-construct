<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function responseError($message = '', $status = Response::HTTP_BAD_REQUEST) {
        return response()->json([
            'status' => 'error',
            // 'error_code' => '',
            'message' => $message
        ], $status);
    }

    public function responseSuccess($data = [], $status = Response::HTTP_OK) {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], $status);
    }
}
