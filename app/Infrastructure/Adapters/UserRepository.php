<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters;

use App\Domain\Ports\In\IUserRepository;
use App\Domain\Entities\Collections\UserCollection;
use App\Domain\Entities\User as UserEntity;
use App\Domain\ValueObjects\Credentials;
use App\Domain\ValueObjects\UserData;
use App\Infrastructure\Models\User;

class UserRepository implements IUserRepository
{
    public function all(): UserCollection
    {
        $users = User::all();
        $userEntities = [];
        
        foreach ($users as $user) {
            $userEntities[] = $this->getUserEntity($user);
        }

        return new UserCollection($userEntities);
    }

    public function save(UserData $userData): ?UserEntity
    {
        if ($this->exists($userData->getEmail())) {
            return null;
        };

        $user = User::create($userData->toDatabase());

        return $this->getUserEntity($user);
    }

    public function update(UserData $userData): ?UserEntity
    {
        $user = User::where('email', $userData->getEmail())->first();

        if (! $user) return null;
        
        $user->update($userData->toDatabase());

        return $this->getUserEntity($user);
    }

    public function getById(int $id): ?UserEntity
    {
        $user = User::find($id);

        if (! $user) return null;
        
        return $this->getUserEntity($user);
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);

        if (! $user) return false;
        
        return $user->delete();
    }

    private function getUserEntity(User $user): UserEntity
    {
        return new UserEntity(
            $user->id,
            $user->name,
            new Credentials($user->email, $user->password),
            $user->remember_token,
            $user->created_at,
            $user->updated_at
        );
    }

    private function exists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}
