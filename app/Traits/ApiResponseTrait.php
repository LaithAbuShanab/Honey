<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Modules\Core\app\Repositories\ErrorLogRepository;
use Modules\Core\app\RepositoriesInterfaces\ErrorLogRepositoryInterface;
use Modules\Core\app\Services\ErrorLog\CreateErrorLogService;

trait ApiResponseTrait
{
    /**
     * Send a success response.
     *
     * @param mixed|null $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse(mixed $data = null, string $message = 'success', int $statusCode = 200): JsonResponse
    {
        if ($message == 'success') {
            $message = __('language.success');
        }
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(
        mixed $data = null,
        string $message = 'error',
        int $statusCode = 500
    ): JsonResponse {
        if ($message == 'error') {
            $message = __('language.error');
        }
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send a validation error response.
     *
     * @param  array  $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function validationErrorResponse(array $errors, int $statusCode = 422): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => __('language.validationFailed'),
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     * Send a not found response.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'notFound'): JsonResponse
    {
        if ($message == 'notFound') {
            $message = __('language.notFound');
        }
        return $this->errorResponse(null, $message, 404);
    }
}
