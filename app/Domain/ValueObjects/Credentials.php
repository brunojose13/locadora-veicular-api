<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class Credentials
{
    public function __construct(
        private string $email, 
        private string $password,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
        ];
    }

    public function toDatabase(): array
    {
        return $this->toArray();
    }
}
