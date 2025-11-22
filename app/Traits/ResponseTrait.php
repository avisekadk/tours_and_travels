<?php

namespace App\Traits;

trait ResponseTrait
{
    // Success response
    public function successResponse($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    // Error response
    public function errorResponse($message = 'Error', $code = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    // Not found response
    public function notFoundResponse($message = 'Resource not found')
    {
        return $this->errorResponse($message, 404);
    }

    // Validation error response
    public function validationErrorResponse($errors)
    {
        return $this->errorResponse('Validation failed', 422, $errors);
    }
}