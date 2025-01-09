<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginRequest, StoreUserRequest};
use App\Http\Resources\{LoginResource, UserResource};
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

final class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (!$token = Auth::attempt($credentials)) {
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

    public function register(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());

            return (new UserResource($user))->additional($this->preparedResponse('store'));
        } catch (QueryException $queryException) {
            return $this->queryExceptionResponse($queryException);
        }
    }
}
