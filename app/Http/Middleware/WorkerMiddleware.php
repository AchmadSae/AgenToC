<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class WorkerMiddleware
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

        $hasWorkerRole = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $user->user_detail_id)
            ->where('roles.role_name', 'worker')
            ->where('user_detail_roles.is_active', true)
            ->exists();


        if (!$hasWorkerRole) {
            Alert::error('Error', 'Unauthorized Page =' . $hasWorkerRole);
            return redirect('/');
        }
        session()->put('currentRole', 'worker');

        return $next($request);
    }
}
