<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /** Usage: ->middleware('permission:users.view') or, for any-of, 'permission:a.create,a.edit'. */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('message', 'Your account has been deactivated.');
        }

        if (! collect($permissions)->contains(fn ($p) => $user->hasPermission($p))) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
