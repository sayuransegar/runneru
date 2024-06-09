<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $timeout = config('session.lifetime') * 120;
            $lastActivity = session('last_activity');

            if ($lastActivity && time() - $lastActivity > $timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors(['message' => 'Session Expired']);
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
