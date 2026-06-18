<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\User as UserEntity;
use App\Domain\Ports\In\IAuthService;
use App\Domain\Ports\Out\LoginOutput;
use App\Domain\Ports\Out\LogoutOutput;
use App\Domain\Ports\Out\UserOutput;
use App\Domain\ValueObjects\Credentials;
use App\Exceptions\CredentialsException;
use App\Infrastructure\Models\User;

class AuthService implements IAuthService
{
    public function authenticate(Credentials $credentials): LoginOutput
    {
        if (! auth()->attempt($credentials->toArray())) {
            throw new CredentialsException();
        }

         /** @var User $user */
         $user = auth()->user();
         $expiresIn = config('auth.token_expiration_minutes', 10);
 
         $token = $user->createToken(
             'Token for user ID: ' . $user->id,
             ['*'],
             now()->addMinutes($expiresIn)
         )->plainTextToken;

        return new LoginOutput($token, (int) $expiresIn);
    }

    public function invalidate(): LogoutOutput
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();

        return new LogoutOutput();
    }

    public function getAttributesFromLoggedAuth(): UserOutput
    {
        /** @var User $user */
        $user = auth()->user();

        $userEntity = new UserEntity(
            $user->id,
            $user->name,
            new Credentials($user->email, $user->password),
            $user->remember_token,
            $user->created_at,
            $user->updated_at
        );

        return new UserOutput($userEntity);
    }
}
