<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class Message
{
    /**
     * Return a success response
     *
     * @param bool $status
     * @param string $message
     * @param mixed $result
     * @return JsonResponse
     */
    public static function formatResponse($status = true, $message = 'SUCCESS', $result = null)
    {
        $response = [
            'status' => $status ? 'success' : 'fail',
            'message' => $message,
            'result' => $result,
        ];

        return $response;
    }
}
