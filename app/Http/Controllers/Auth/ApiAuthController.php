<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\Traits\ApiResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

final class ApiAuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (! $token = Auth::attempt($credentials)) {
                return $this->unauthorizedResponse();
            }

            return new LoginResource($token);
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        } catch (Exception $exception) {
            $this->recordException($exception);

            return $this->serverErrorResponse();
        }
    }

    public function logout()
    {
        try {
            Auth::logout();

            return $this->preparedResponse('logout');
        } catch (Exception $exception) {
            $this->recordException($exception);

            return $this->serverErrorResponse();
        }
    }

    public function register(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());

            return (new UserResource($user))->additional($this->preparedResponse('store'));
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    }

    public function refresh()
    {
        try {
            $newToken = Auth::refresh();

            return new LoginResource($newToken);
        } catch (Exception $exception) {
            $this->recordException($exception);

            return $this->serverErrorResponse();
        }
    }

    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
