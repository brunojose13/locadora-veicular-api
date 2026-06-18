<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Ports\IEntity;
use App\Domain\ValueObjects\Credentials;
use Illuminate\Support\Carbon;

class User implements IEntity
{
    public function __construct(
        private int $id,
        private string $name,
        private Credentials $credentials,
        private ?string $rememberToken,
        private ?Carbon $createdAt,
        private ?Carbon $updatedAt,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    public function getEmail(): string
    {
        return $this->getCredentials()->getEmail();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'createdAt' => $this->createdAt?->toDateTimeString(),
            'updatedAt' => $this->updatedAt?->toDateTimeString(),
        ];
    }

    public function toDatabase(): array
    {
        return array_merge([
            'name' => $this->getName(),
        ], $this->getCredentials()->toDatabase());
    }
}
