<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->select('roles.name as role')
            ->where('users.id', auth()->user()->id);
        if ($user != 'admin') {
            return redirect('/')->with('error', 'Unauthorized Page');
        }

        return $next($request);
    }
}
