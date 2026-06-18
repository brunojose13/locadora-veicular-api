<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Domain\Ports\IJsonResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageResponse implements IJsonResponse
{
    public function __construct(
        private string $message = '', 
        private int $statusCode = 200,
    ) {}

    public function getResponse(): JsonResponse
    {
        return response()->json([
            'responseStatus' => Response::$statusTexts[$this->statusCode] ?? 'OK',
            'message' => $this->message ?? null
        ], $this->statusCode);
    }
}
