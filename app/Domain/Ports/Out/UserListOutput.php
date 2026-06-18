<?php

declare(strict_types=1);

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Collections\UserCollection;
use function App\Helpers\getClassShortName;
use Illuminate\Support\Str;

class UserListOutput
{
    public function __construct(
        private UserCollection $userCollection,
    ) {}

    public function getOutput(): array
    {
        return [
            Str::camel(getClassShortName($this->userCollection)) => $this->userCollection->toArray()
        ];
    }
}
