<?php

namespace App\Traits;

use App\Enums\StatusCode;

trait HttpResponses
{


    public function success($data, $message = 'Okay', $code = StatusCode::Success->value)
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public function failed($data, $code, $message = 'Failed')
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
