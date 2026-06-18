<?php

use App\Domain\Ports\In\IUserRepository;
use App\Domain\Entities\Collections\UserCollection;
use App\Domain\Entities\User as UserEntity;
use App\Domain\ValueObjects\Credentials;
use App\Domain\ValueObjects\UserData;
use App\Infrastructure\Models\User;

beforeEach(function () {
    $this->userRepository = $this->app->make(IUserRepository::class);
});

describe('CRUD for User', function () {
    it('may list all', function () {
        $userEntityCollection = $this->userRepository->all();

        expect($userEntityCollection)->toBeInstanceOf(UserCollection::class);
    });

    it('may create', function (User $user) {
        $user->delete();

        $userEntity = $this->userRepository->save(new UserData(
            $user->name,
            new Credentials($user->email, $user->password),
        ));

        expect($userEntity)->toBeInstanceOf(UserEntity::class);
    })->with('userModel');

    it('may update', function (User $user) {
        $userEntity = $this->userRepository->update(new UserData(
            $user->name,
            new Credentials($user->email, $user->password),
        ));

        expect($userEntity)->toBeInstanceOf(UserEntity::class);
    })->with('userModel');

    it('may search', function (User $user) {
        $userEntity = $this->userRepository->getById($user->id);

        expect($userEntity)->toBeInstanceOf(UserEntity::class);
    })->with('userModel');

    it('may delete', function (User $user) {
        $success = $this->userRepository->delete($user->id);

        expect($success)->toBeTrue();
    })->with('userModel');
});
