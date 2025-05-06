<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
  /**
   * Send success response
   */
  public static function success(
    mixed $data = null,
    string $message = 'Success',
    int $statusCode = 200
  ): JsonResponse {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $data
    ], $statusCode);
  }

  /**
   * Send error response
   */
  public static function error(
    string $message = 'Error occurred',
    int $statusCode = 400,
    mixed $errors = null
  ): JsonResponse {
    return response()->json([
      'success' => false,
      'message' => $message,
      'errors' => $errors
    ], $statusCode);
  }

  /**
   * Send not found response
   */
  public static function notFound(
    string $message = 'Resource not found'
  ): JsonResponse {
    return self::error($message, 404);
  }

  /**
   * Send validation error response
   */
  public static function validationError(
    mixed $errors,
    string $message = 'Validation errors'
  ): JsonResponse {
    return self::error($message, 422, $errors);
  }

  /**
   * Send unauthorized response
   */
  public static function unauthorized(
    string $message = 'Unauthorized'
  ): JsonResponse {
    return self::error($message, 401);
  }
}
