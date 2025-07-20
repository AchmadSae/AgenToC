<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserImpl implements UserInterface
{
    public function getSpecifiedRole($role): Collection
    {
        $data = [];
        switch ($role) {
            case 'admin':
                $data = DB::table('user_detail_roles')
                    ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
                    ->where('roles.role_name', $role)
                    ->get();
                break;
            case 'user':
                $data = DB::table('user_detail_roles')
                    ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
                    ->where('roles.role_name', $role)
                    ->get();
                break;
            case 'worker':
                $data = DB::table('user_detail_roles')
                    ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
                    ->where('roles.role_name', $role)
                    ->get();
                break;
            default:
                $data = User::all();
                break;
        }

        return $data;
    }
}