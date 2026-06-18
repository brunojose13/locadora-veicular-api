<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Ports\IEntity;
use Illuminate\Support\Carbon;

class Car implements IEntity
{
    public function __construct(
        private int $id,
        private string $brand,
        private string $model,
        private int $age,
        private float $price,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
        private ?Carbon $deletedAt = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'brand' => $this->brand,
            'model' => $this->model,
            'age' => $this->age,
            'price' => $this->price,
            'createdAt' => $this->createdAt?->toDateTimeString(),
            'updatedAt' => $this->updatedAt?->toDateTimeString(),
        ];

        if (! empty($this->deletedAt)) {
            $data['deletedAt'] = $this->deletedAt->toDateTimeString();
        }

        return $data;
    }

    public function toDatabase(): array
    {
        $data = $this->toArray();

        unset($data['createdAt']);
        unset($data['updatedAt']);

        return $data;
    }
}
