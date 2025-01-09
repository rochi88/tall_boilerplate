<?php

declare(strict_types = 1);

namespace App\Http\Resources;

use App\Enums\{ApiStatus, Messages};
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class LoginResource extends JsonResource
{
    public static $wrap;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'response' => [
                'status'      => ApiStatus::SUCCESS,
                'status_code' => Response::HTTP_OK,
                'message'     => Messages::LOGIN_SUCCESSFUL,
                'data'        => [
                    'token_type'   => 'bearer',
                    'access_token' => $this->resource,
                    'expires_in'   => Auth::factory()->getTTL() * 60,
                ],
            ],
        ];
    }
}
