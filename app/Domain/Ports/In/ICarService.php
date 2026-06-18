<?php

declare(strict_types=1);

namespace App\Domain\Ports\In;

use App\Domain\Entities\Car;
use App\Domain\Ports\Out\CarListOutput;
use App\Domain\Ports\Out\CarOutput;
use App\Domain\Ports\Out\DeletedCarOutput;
use App\Domain\ValueObjects\CarData;

interface ICarService
{
    public function getCars(): CarListOutput;

    public function createCar(CarData $carData): CarOutput;

    public function updateCar(Car $car): CarOutput;

    public function getCarById(int $id): CarOutput;

    public function deleteCar(int $id): DeletedCarOutput;

    public function getDeletedCars(): CarListOutput;
}
