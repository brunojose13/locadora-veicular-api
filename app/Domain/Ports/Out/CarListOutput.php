<?php

declare(strict_types=1);

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Collections\CarCollection;
use function App\Helpers\getClassShortName;
use Illuminate\Support\Str;

class CarListOutput
{
    public function __construct(
        private CarCollection $carCollection,
    ) {}

    public function getOutput(): array
    {
        return [
            Str::camel(getClassShortName($this->carCollection)) => $this->carCollection->toArray(),
        ];
    }
}
