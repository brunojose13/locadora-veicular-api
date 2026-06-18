<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Ports\In\IUserService;
use App\Domain\ValueObjects\Credentials;
use App\Domain\ValueObjects\UserData;
use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\ArrayResponse;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ServerErrorResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct(
        private IUserService $userService,
    ) {}

    public function index(): Response
    {
        try {
            $response = new ArrayResponse($this->userService->getUsers()->getOutput());
        
        } catch (\Throwable $t) {
            $response = new ServerErrorResponse(
                $t->getFile(),
                $t->getLine(),
                $t->getTraceAsString(),
                $t->getMessage()
            );
        }

        return $response->getResponse();
    }

    public function show(Request $request): Response
    {
        try {
            $output = $this->userService->getUserById(
                (int) $request->route('id')
            );
            
            $response = new ArrayResponse($output->getOutput());

        } catch (UserNotFoundException $exception) {
            $response = new MessageResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (\Throwable $t) {
            $response = new ServerErrorResponse(
                $t->getFile(),
                $t->getLine(),
                $t->getTraceAsString(),
                $t->getMessage()
            );
        }

        return $response->getResponse();
    }

    public function store(StoreUserRequest $request): Response
    {
        try {
            $output = $this->userService->createUser(new UserData(
                $request->input('name'),
                new Credentials(
                    $request->input('email'), 
                    $request->input('password')
                )
            ));
                
            $response = new ArrayResponse($output->getOutput(), Response::HTTP_CREATED);

        } catch (UserAlreadyExistsException $e) {
            $response = new MessageResponse($e->getMessage(), Response::HTTP_EXPECTATION_FAILED);

        } catch (\Throwable $t) {
            $response = new ServerErrorResponse(
                $t->getFile(),
                $t->getLine(),
                $t->getTraceAsString(),
                $t->getMessage()
            );
        }

        return $response->getResponse();
    }

    public function update(UpdateUserRequest $request): Response
    {
        try {
            $output = $this->userService->updateUser(new UserData(
                $request->input('name'),
                new Credentials(
                    $request->user()->email, 
                    $request->input('password')
                )
            ));
                
            $response = new ArrayResponse($output->getOutput());

        } catch (UserNotFoundException $exception) {
            $response = new MessageResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (\Throwable $t) {
            $response = new ServerErrorResponse(
                $t->getFile(),
                $t->getLine(),
                $t->getTraceAsString(),
                $t->getMessage()
            );

        }

        return $response->getResponse();
    }

    public function destroy(Request $request): Response
    {
        try {
            $output = $this->userService->deleteUser(
                $request->user()->id
            );
            
            $response = new ArrayResponse($output->getOutput());

        } catch (UserNotFoundException $exception) {
            $response = new MessageResponse($exception->getMessage(), Response::HTTP_NOT_FOUND);

        } catch (\Throwable $t) {
            $response = new ServerErrorResponse(
                $t->getFile(),
                $t->getLine(),
                $t->getTraceAsString(),
                $t->getMessage()
            );
        }

        return $response->getResponse();
    }
}
