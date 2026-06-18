<?php

use App\Domain\Ports\Out\CarListOutput;
use App\Domain\Ports\Out\CarOutput;
use App\Domain\Ports\Out\DeletedCarOutput;
use App\Domain\Entities\Car as CarEntity;
use App\Domain\Ports\In\ICarService;
use App\Domain\ValueObjects\CarData;
use App\Exceptions\CarNotFoundException;
use App\Infrastructure\Models\Car;

beforeEach(function () {
    $this->carService = $this->app->make(ICarService::class);
});

describe('CRUD for Car', function () {
    it('gets all cars', function () {
        Car::factory(2)->create();
        
        $outputObject = $this->carService->getCars();
        $output = $outputObject->getOutput();

        expect($outputObject)->toBeInstanceOf(CarListOutput::class);
        expect($output)->toBeArray();

        expect($output['carCollection'])
            ->not->toBeEmpty()
            ->toHaveCount(2);
    });

    it('creates a car', function (CarData $carData) {
        $outputObject = $this->carService->createCar($carData);
        $output = $outputObject->getOutput();
        
        expect($outputObject)->toBeInstanceOf(CarOutput::class);
        expect($output)->toBeArray();
        
        expect($output['car']['brand'])->toBe('Jeep')
            ->and($output['car']['model'])->toBe('Renegade');
    })->with('carData');

    it('updates a car', function (Car $car) {
        $outputObject = $this->carService->updateCar(new CarEntity(
            $car->id,
            'Toyota',
            'Corolla',
            2021,
            300
        ));

        $output = $outputObject->getOutput();

        expect($outputObject)->toBeInstanceOf(CarOutput::class);
        expect($output)->toBeArray();
        
        expect($output['car']['brand'])->toBe('Toyota')
            ->and($output['car']['model'])->toBe('Corolla')
            ->and($output['car']['age'])->toBe(2021)
            ->and($output['car']['price'])->toBe((float) 300);
    })->with('carModel');

    it('throws when updating a non-existent car', function () {
        $this->carService->updateCar(new CarEntity(
            1,
            '',
            '',
            0,
            0
        ));
    })->expectException(CarNotFoundException::class);

    it('gets a car by ID', function (Car $car) {       
        $outputObject = $this->carService->getCarById($car->id);
        $output = $outputObject->getOutput();

        expect($outputObject)->toBeInstanceOf(CarOutput::class);
        expect($output)->toBeArray();
    })->with('carModel');

    it('throws when getting a non-existent car by ID', function () {
        $this->carService->getCarById(1);
    })->expectException(CarNotFoundException::class);

    it('deletes a car', function (Car $car) {
        $outputObject = $this->carService->deleteCar($car->id);

        expect($outputObject)->toBeInstanceOf(DeletedCarOutput::class);
    })->with('carModel');

    it('throws when deleting a non-existent car', function () {
        $this->carService->deleteCar(1);
    })->expectException(CarNotFoundException::class);

    it('gets all deleted cars', function (Car $car) {
        $car->delete();

        $outputObject = $this->carService->getDeletedCars();

        expect($outputObject)->toBeInstanceOf(CarListOutput::class);
        expect($outputObject->getOutput())->toBeArray();
    })->with('carModel');
});
