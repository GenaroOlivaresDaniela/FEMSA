<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\HttpStatusEnum;

/**
 * ResponseHelper
 *
 * @package App\Helpers
 * @author Daniela
 */
class ResponseHelper
{
    /**
     * Response standard for API
     *
     * @param int $status
     * @param array|object|string|int|null $data
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function standard(int $status, $data = null, string $message = null)
    {
        $response = [
            'status'      => $status,
            'request-id'  => self::getRequestId(),
            'server'      => [
                'host'     => request()->getHost(),
                'url'      => request()->url(),
                'datetime' => Carbon::now()->toDateTimeString()
            ],
            'message'     => $message,
            'data'        => $data,
        ];

        return response()->json($response, $status);
    }

    /**
     * Response status 404
     *
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public static function send404(): void
    {
        abort(
            HttpStatusEnum::NOT_FOUND,
            'La solicitud se realizó de forma correcta, sin embargo, el servicio no obtuvo información alguna.'
        );
    }

    /**
     * Response json
     *
     * @param array|object|string|int|null $data
     * @param string|null $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function json($data = null, string $message = null, int $status = HttpStatusEnum::OK)
    {
        return (new Self)->standard($status, $data, $message);
    }

    /**
     * Response json error
     *
     * @param string $message
     * @param array|object|string|int|null $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonError(string $message, $data = null, int $status = HttpStatusEnum::INTERNAL_SERVER_ERROR)
    {
        $requestId = self::getRequestId();
        $message   = "{$message} ({$requestId})";

        error_($message,$data ?? []);

        return (new Self)->json($data, $message, $status);
    }

    /**
     * Get the request id
     *
     * @return string
     */
    public static function getRequestId(): string
    {
        return request()->header('X-Request-ID') ?? Str::uuid();
    }
}
