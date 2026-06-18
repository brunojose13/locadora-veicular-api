<?php

declare(strict_types=1);

namespace App\Domain\Ports\In;

use App\Domain\Ports\Out\LoginOutput;
use App\Domain\Ports\Out\LogoutOutput;
use App\Domain\Ports\Out\UserOutput;
use App\Domain\ValueObjects\Credentials;

interface IAuthService
{
    public function authenticate(Credentials $credentials): LoginOutput;

    public function invalidate(): LogoutOutput;

    public function getAttributesFromLoggedAuth(): UserOutput;
}
