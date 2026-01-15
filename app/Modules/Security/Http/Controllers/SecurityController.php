<?php

declare(strict_types=1);

namespace App\Modules\Security\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class SecurityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'module' => 'Security',
            'status' => 'ok',
        ]);
    }
}
