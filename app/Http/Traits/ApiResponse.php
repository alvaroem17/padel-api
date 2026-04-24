<?php

namespace App\Http\Traits;

use Illuminate\Pagination\Paginator;

trait ApiResponse
{
    /**
     * Respuesta exitosa genérica
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message = null, $code = 200)
    {
        $response = [];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Respuesta de error
     *
     * @param string $message
     * @param int $code
     * @param array|null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code = 400, $errors = null)
    {
        $response = ['message' => $message];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Respuesta paginada
     *
     * @param Paginator $paginated
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginatedResponse($paginated, $message = null)
    {
        $response = [
            'data' => $paginated->items(),
            'pagination' => [
                'total' => $paginated->total(),
                'count' => $paginated->count(),
                'per_page' => $paginated->perPage(),
                'current_page' => $paginated->currentPage(),
                'total_pages' => ceil($paginated->total() / $paginated->perPage()),
            ]
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, 200);
    }
}
