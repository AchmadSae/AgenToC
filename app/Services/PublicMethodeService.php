<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;



class PublicMethodeService
{
    public function getRoleNameAndUsername($user): array
    {
        $name = $user->name ?? '';
        $role_name = '';
        $response = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $user->user_detail_id)
            ->where('user_detail_roles.is_active', true)
            ->value('roles.role_name');
        if ($response === null) {
            throw new \Exception('Role not found for user: ' . $user->user_detail_id);
        }
        $role_name = $response;

        return [
            'role_name' => $name,
            'username' => $role_name
        ];
    }
}
