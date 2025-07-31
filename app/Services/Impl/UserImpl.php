<?php

namespace App\Services\Impl;

use App\Models\EmployeeModel;
use App\Models\User;
use App\Models\UserDetailModel;
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

    /**
     * update user specific role
     **/

    public function updateUser(array $data, $role, $isEmployee = false)
    {
        $user_detail_id = $data['user_detail_id'];
        switch ($role) {
            case 'client':
                $model = UserDetailModel::find($user_detail_id)->first()->lockForUpdate();
                DB::transaction(function () use ($model, $data) {
                    $model->update([
                        'address_detail' => $data['address_detail'],
                        'phone_number' => $data['phone_number'],
                        'postal_code' => $data['postal_code'],
                        'credit_number' => $data['credit_number']
                    ]);
                    return $model;
                });
                break;
            case 'worker':
                $model = UserDetailModel::find($user_detail_id)->first()->lockForUpdate();
                DB::transaction(function () use ($model, $data) {
                    $model->update([
                        'skills' => $data['skills'],
                        'tag_line' => $data['tag_line'],
                        'address_detail' => $data['address_detail'],
                        'phone_number' => $data['phone_number'],
                        'postal_code' => $data['postal_code'],
                        'credit_number' => $data['credit_number']
                    ]);
                    return $model;
                });
                break;
            case 'admin':
                if (!$isEmployee) {
                    return null;
                }
                $model = EmployeeModel::where('email', $data['email'])->first()->lockForUpdate();
                DB::transaction(function () use ($model, $data) {
                    $model->update([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone_number' => $data['phone_number'],
                        'position' => $data['position']
                    ]);
                    return $model;
                });
                break;
            default:
                return null;
        }
    }
}