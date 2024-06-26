<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Entities\Setting;

class IpCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $approved = [];
            $ips = Setting::where('key', 'ips')->value('value');

            if ($ips !== null) {
                $ips = json_decode($ips, true);

                foreach ($ips as $row) {
                    $approved[] = $row['ip'];
                }

                if (in_array($request->ip(), $approved, true) && auth()->user()->is_office_login_only === 1) {
                    Auth::guard()->logout();

                    return redirect()->route('login');
                }
            }
        }

        return $next($request);
    }
}
