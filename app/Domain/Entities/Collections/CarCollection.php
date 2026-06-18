<?php

declare(strict_types=1);

namespace App\Domain\Entities\Collections;

use App\Domain\Entities\Car;

class CarCollection extends Collection
{
    /**
     * @param Car[] $cars Array contendo instâncias de Car
     */
    public function __construct(array $cars)
    {
        parent::__construct($cars, Car::class);
    }
}
