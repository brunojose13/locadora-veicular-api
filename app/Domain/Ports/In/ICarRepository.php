<?php

declare(strict_types=1);

namespace App\Domain\Ports\In;

use App\Domain\Entities\Car;
use App\Domain\Entities\Collections\CarCollection;
use App\Domain\ValueObjects\CarData;

interface ICarRepository
{
    public function all(): CarCollection;

    public function save(CarData $carData): Car;

    public function update(Car $car): ?Car;

    public function getById(int $id): ?Car;

    public function delete(int $id): bool;

    public function allDeleted(): CarCollection;
}
