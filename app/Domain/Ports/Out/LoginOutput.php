<?php

declare(strict_types=1);

namespace App\Domain\Ports\Out;

class LoginOutput
{
    public function __construct(
        private string $token,
        private int $expiresIn,
    ) {}

    public function getOutput(): array
    {
        return [
            'message' => 'Login realizado com sucesso!',
            'token' => $this->token,
            'expiresIn' => $this->expiresIn . ' minutes'
        ];
    }
}
