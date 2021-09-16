<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param int $code
     * @return Response
     */

    public function sendApiResponse($message, $result = null, $code = Response::HTTP_OK)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'code' => $code
        ];

        if (!empty($result)) {
            $response['payload'] = $result;
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param $errorMessages
     * @param int $code
     * @return Response
     */
    public function sendApiError($errorMessages, $code = Response::HTTP_OK)
    {
        $response = [
            'status' => "error",
            'code' => $code
        ];

        if (!empty($errorMessages)) {
            $response['message'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @param array $errorMessages
     * @param int $code
     * @return Response
     */
    public function sendApiValidationError($errorMessages = [], $code = Response::HTTP_OK)
    {
        $response = [
            'status' => "validation-error",
            'code' => $code
        ];

        if (!empty($errorMessages)) {
            $response['payload'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
