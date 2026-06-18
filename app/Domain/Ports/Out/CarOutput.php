<?php

declare(strict_types=1);

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Car;
use function App\Helpers\getClassShortName;
use Illuminate\Support\Str;

class CarOutput
{
    public function __construct(
        private Car $car,
    ) {}

    public function getOutput(): array
    {
        return [
            Str::camel(getClassShortName($this->car)) => $this->car->toArray()
        ];
    }
}
