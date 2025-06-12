<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\GenerateId;
use App\Models\User;
use App\Models\UserDetailModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        GenerateId::generateWithDate('UD');

        $user_detail1 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'profile_photo_path' => 'https://ui-avatars.com/api/?name=Aji+Setyo&background=0D8ABC&color=fff',
            'role_id' => GenerateId::generateWithDate('R'),
            'address_detail' => 'Jl. Kebon Jeruk No. 1',
            'phone_number' => '08123456789',
            'postal_code' => '12345',
            'credit_number' => '1234567890123456',
            'balance_coins' => 10,
            'is_active' => true
        ]);
        $user_detail2 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'profile_photo_path' => 'https://ui-avatars.com/api/?name=Lamine+Yamal&background=0D8ABC&color=fff',
            'role_id' => GenerateId::generateWithDate('R'),
            'address_detail' => 'Jl. Kebon Jeruk No. 2',
            'phone_number' => '0845678901',
            'postal_code' => '12345',
            'credit_number' => '26192891012345678',
            'balance_coins' => 10,
            'is_active' => true
        ]);

        User::insert([
            [
                'name' => 'Aji Setyo',
                'user_detail_id' => $user_detail1->id,
                'email' => 'ajisetyo@gmail.com',
                'password' => Hash::make('samplepassword')
            ],
            [
                'name' => 'Lamine Yamal',
                'user_detail_id' => $user_detail2->id,
                'email' => 'sssnerv@gmail.com',
                'password' => Hash::make('samplepassword')
            ]
        ]);

        DB::table('roles')->insert([
            [
                'role_id' => $user_detail1->role_id,
                'role_name' => 'Admin',
                'is_active' => true
            ],
            [
                'role_id' => $user_detail2->role_id,
                'role_name' => 'User',
                'is_active' => true
            ],
            [
                'role_id' => $user_detail1->role_id,
                'role_name' => 'User',
                'is_active' => true
            ],
            [
                'role_id' => $user_detail2->role_id,
                'role_name' => 'Admin',
                'is_active' => true
            ]
        ]);
    }
}
