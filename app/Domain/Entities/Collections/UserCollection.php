<?php

declare(strict_types=1);

namespace App\Domain\Entities\Collections;

use App\Domain\Entities\User;

class UserCollection extends Collection
{
    /**
     * @param User[] $users Array contendo instâncias de User
     */
    public function __construct(array $users)
    {
        parent::__construct($users, User::class);
    }
}
