<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            Alert::info('Error', 'You are not logged in');
            return $next($request);
        }

        $hasAdminRole = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $user->user_detail_id)
            ->where('roles.role_name', 'admin')
            ->where('user_detail_roles.is_active', true)
            ->exists();

        if (!$hasAdminRole) {
            Alert::error('Error', 'Unauthorized Page');
            return redirect('/');
        }
        session()->put('currentRole', 'Admin');

        return $next($request);
    }
}
