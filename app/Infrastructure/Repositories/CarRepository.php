<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Ports\In\ICarRepository;
use App\Domain\Entities\Car as CarEntity;
use App\Domain\Entities\Collections\CarCollection;
use App\Domain\ValueObjects\CarData;
use App\Infrastructure\Models\Car;

class CarRepository implements ICarRepository
{
    public function all(): CarCollection
    {
        $cars = Car::all();
        $carEntities = [];
        
        foreach ($cars as $car) {
            $carEntities[] = $this->getCarEntity($car);
        }

        return new CarCollection($carEntities);
    }

    public function save(CarData $carData): CarEntity
    {
        $car = Car::create($carData->toDatabase());

        return $this->getCarEntity($car);
    }

    public function update(CarEntity $carEntity): ?CarEntity
    {
        $car = Car::find($carEntity->getId());

        if (! $car) return null;
        
        $car->update($carEntity->toDatabase());

        return $this->getCarEntity($car);
    }

    public function getById(int $id): ?CarEntity
    {
        $car = Car::find($id);

        if (! $car) return null;
        
        return $this->getCarEntity($car);
    }

    public function delete(int $id): bool
    {
        $car = Car::find($id);

        if (! $car) return false;
        
        return $car->delete();
    }

    public function allDeleted(): CarCollection
    {
        $cars = Car::onlyTrashed()->getModels();
        $carEntities = [];
        
        foreach ($cars as $car) {
            $carEntities[] = $this->getCarEntity($car);
        }

        return new CarCollection($carEntities);
    }

    private function getCarEntity(Car $car): CarEntity
    {
        return new CarEntity(
            $car->id,
            $car->brand,
            $car->model, 
            $car->age,
            $car->price,
            $car->created_at,
            $car->updated_at,
            $car->deleted_at
        );
    }
}
