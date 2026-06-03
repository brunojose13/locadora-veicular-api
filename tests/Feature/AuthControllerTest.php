<?php

use App\Infrastructure\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;

describe('Authentication', function () {
    $credentials = [
        'email' => 'test@test.com',
        'password' => '123456'
    ];

    it('can make a login', function () use ($credentials) {
        User::factory()->create($credentials);

        $request = Request::create(
            route('login', $credentials),
            'POST'
        );

        $response = app()->handle($request);
        
        expect($request->method())->toBe('POST');
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())
            ->toBeInt()
            ->toBe(Status::HTTP_ACCEPTED);
    });

    it('can make a logout', function () use ($credentials) {
        $user = User::factory()->create($credentials);
        $token = $user->createToken('test-token')->plainTextToken;

        $request = Request::create(
            route('logout'),
            'DELETE'
        );

        $request->headers->set('Authorization', 'Bearer ' . $token);
        $response = app()->handle($request);

        expect($request->method())->toBe('DELETE');
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())
            ->toBeInt()
            ->toBe(Status::HTTP_OK);
    });

    it('keeps the user active', function () use ($credentials) {
        $user = User::factory()->create($credentials);
        $token = $user->createToken('test-token')->plainTextToken;

        $request = Request::create(
            route('authenticated.user')
        );

        $request->headers->set('Authorization', 'Bearer ' . $token);
        $response = app()->handle($request);
        
        expect($request->method())->toBe('GET');
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())
            ->toBeInt()
            ->toBe(Status::HTTP_OK);
        
        $userFromResponse = json_decode($response->getContent())->User;

        expect($userFromResponse)->toHaveProperties(
            array_keys($user->toArray())
        );
    });

    it('will block unauthorized users', function () {
        $request = Request::create(
            route('authenticated.user')
        );

        // Esse handle() retornará uma string contendo um html de redicionamento para a rota `unauthorized`
        $html = app()->handle($request)->getContent();
        
        preg_match('/url=\'(.*?)\'/', $html, $matches);
        $url = $matches[1];
    
        $requestToUnauthorized = Request::create($url);

        // O handle() será utilizado novamente para uma nova requisição na rota `unauthorized`
        $response = app()->handle($requestToUnauthorized);
        
        expect($request->method())->toBe('GET');
        expect($requestToUnauthorized->method())->toBe('GET');
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())
            ->toBeInt()
            ->toBe(Status::HTTP_UNAUTHORIZED);
    });
});
