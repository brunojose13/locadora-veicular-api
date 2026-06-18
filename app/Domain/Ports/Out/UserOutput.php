<?php

declare(strict_types=1);

namespace App\Domain\Ports\Out;

use App\Domain\Entities\User;
use function App\Helpers\getClassShortName;
use Illuminate\Support\Str;

class UserOutput
{

    public function __construct(
        private User $user
    ) {}

    public function getOutput(): array
    {
        return [
            Str::camel(getClassShortName($this->user)) => $this->user->toArray()
        ];
    }
}
