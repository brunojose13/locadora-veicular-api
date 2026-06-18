<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Domain\Ports\IJsonResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ServerErrorResponse implements IJsonResponse
{
    private int $statusCode;

    public function __construct(
        private string $exceptionOrigin,
        private int $exceptionLine,
        private string $exceptionTrace,
        private string $message,
    ) {
        $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function getResponse(): JsonResponse
    {
        return response()->json([
            'responseStatus' => Response::$statusTexts[$this->statusCode],
            'message' => $this->message,
            'file' => $this->exceptionOrigin,
            'line' => $this->exceptionLine,
            'trace' => $this->exceptionTrace
        ], $this->statusCode);
    }
}
