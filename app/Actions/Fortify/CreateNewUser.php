<?php

namespace App\Actions\Fortify;

use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\UserDetailModel;
use App\Helpers\GenerateId;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['required'],
            'tagline' => ['max:255'],
            'skills' => ['max:255'],
        ])->validate();



        $userRole = RoleModel::create([
            'role_id' => GenerateId::generateWithDate('R'),
            'role_name' => $input['role'],
            'is_active' => true
        ]);

        $userDetail = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'role_id' => $userRole->id,
            'skills' => $input['skills'],
            'tagline' => $input['tagline'],
        ]);

        return $user = User::create([
            'user_detail_id' => $userDetail->id,
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);



    }
}
