<?php

declare(strict_types=1);

namespace App\Domain\Ports\In;

use App\Domain\Entities\Collections\UserCollection;
use App\Domain\Entities\User;
use App\Domain\ValueObjects\UserData;

interface IUserRepository
{
    public function all(): UserCollection;

    public function save(UserData $userData): ?User;

    public function update(UserData $userData): ?User;

    public function getById(int $id): ?User;

    public function delete(int $id): bool;
}
