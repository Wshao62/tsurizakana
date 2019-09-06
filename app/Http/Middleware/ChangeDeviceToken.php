<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ChangeDeviceToken
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $dt = $request->headers->get('devicetoken');
            $os_type = $request->headers->get('os-type');
            $old_dt = $request->headers->get('old-devicetoken');
            if (!empty($dt)) {
                Auth::user()->addDeviceToken($os_type, $dt);
            }
            if (!empty($old_dt)) {
                Auth::user()->removeDeviceToken($os_type, $old_dt);
            }
        }
        return $next($request);
    }
}
