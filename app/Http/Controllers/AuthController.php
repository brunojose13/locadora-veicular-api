<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Ports\In\IAuthService;
use App\Domain\ValueObjects\Credentials;
use App\Exceptions\CredentialsException;
use App\Exceptions\UnauthorizedUserException;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ArrayResponse;
use App\Http\Responses\MessageResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private IAuthService $authService,
    ) {}

    public function login(LoginRequest $request): Response
    {
        try{
            $output = $this->authService->authenticate(new Credentials(
                $request->input('email'),
                (string) $request->input('password'),
            ));

            $response = new ArrayResponse($output->getOutput(), Response::HTTP_ACCEPTED);

        } catch (CredentialsException $e) {
            $response = new MessageResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);    
        }

        return $response->getResponse();
    }

    public function logout(): Response
    {
        $output = $this->authService->invalidate();
        $response = new MessageResponse($output->getOutput());
        
        return $response->getResponse();
    }

    public function recoverAuthenticated(): Response
    {
        $output = $this->authService->getAttributesFromLoggedAuth();
        $response = new ArrayResponse($output->getOutput());
        
        return $response->getResponse();
    }

    public function unauthorize(): Response
    {
        try {
            $this->authService->getDeauthorizeMessage();

        } catch (UnauthorizedUserException $e) {
            $response = new MessageResponse(
                $e->getMessage(),
                Response::HTTP_UNAUTHORIZED,
            );
        } 
        
        return $response->getResponse();
    }
}
