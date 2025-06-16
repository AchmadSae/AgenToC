<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $query = DB::table('user_detail')
            ->join('users', 'users.user_detail_id', '=', 'user_detail.id')
            ->join('roles', 'roles.role_id', '=', 'user_detail.role_id')
            ->where('users.user_detail_id', auth()->user()->user_detail_id)
            ->select('users.name', 'roles.role_name')
            ->get();

        $user = $query->pluck('role_name');
        if (!$user->contains('Users')) {
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        return $next($request);
    }
}
