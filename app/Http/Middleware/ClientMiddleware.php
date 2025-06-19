<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $hasUserRole = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $user->user_detail_id)
            ->where('roles.role_name', 'user')
            ->where('user_detail_roles.is_active', true)
            ->exists();

        if (!$hasUserRole) {
            Alert::error('Error', 'Unauthorized Page=' . $hasUserRole . 'user_detail_id=' . $user->user_detail_id . 'role_name=' . $user->role_name);
            return redirect('/');
        }
        return $next($request);
    }
}
