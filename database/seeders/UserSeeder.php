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
            'role_id' => GenerateId::generateWithDate('R'),
            'address_detail' => 'Jl. Kebon Jeruk No. 1',
            'phone_number' => '08123456789',
            'postal_code' => '12345',
            'credit_number' => '1234567890123456',
            'balance_coins' => 10,
        ]);
        $user_detail2 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'role_id' => GenerateId::generateWithDate('R'),
            'address_detail' => 'Jl. Kebon Jeruk No. 2',
            'phone_number' => '0845678901',
            'postal_code' => '12345',
            'credit_number' => '26192891012345678',
            'balance_coins' => 10,
        ]);

        $user_detail3 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'role_id' => GenerateId::generateWithDate('R'),
            'address_detail' => 'Jl. Kebon Jeruk No. 2',
            'phone_number' => '0845678901',
            'postal_code' => '13345',
            'credit_number' => '26131891012345678',
            'balance_coins' => 5,
        ]);
        $user_detail4 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'role_id' => GenerateId::generateWithDate('R'),
            'address_detail' => 'Jl. Kebon Jeruk No. 4',
            'phone_number' => '624845678901',
            'postal_code' => '13345',
            'credit_number' => '26131891012345678',
            'balance_coins' => 5,
        ]);

        User::insert([
            [
                'name' => 'Aji Setyo',
                'user_detail_id' => $user_detail1->id,
                'email' => 'ajisetyo@gmail.com',
                'password' => Hash::make('samplepassword'),
                'profile_photo_path' => 'https://ui-avatars.com/api/?name=Aji+Setyo&background=0D8ABC&color=fff',
            ],
            [
                'name' => 'Lamine Yamal',
                'user_detail_id' => $user_detail2->id,
                'email' => 'sssnerv@gmail.com',
                'password' => Hash::make('samplepassword'),
                'profile_photo_path' => 'https://ui-avatars.com/api/?name=Lamine+Yamal&background=0D8ABC&color=fff',
            ],
            [
                'name' => 'Seno Maulana',
                'user_detail_id' => $user_detail3->id,
                'email' => 'senomaulana@gmail.com',
                'password' => Hash::make('samplepassword'),
                'profile_photo_path' => 'https://ui-avatars.com/api/?name=Seno+Maulana&background=0D8ABC&color=fff',
            ],
            [
                'name' => 'Dylan',
                'user_detail_id' => $user_detail4->id,
                'email' => 'dylan@gmail.com',
                'password' => Hash::make('samplepassword'),
                'profile_photo_path' => 'https://ui-avatars.com/api/?name=Dylan&background=0D8ABC&color=fff',
            ],


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
            ],
            [
                'role_id' => $user_detail3->role_id,
                'role_name' => 'Worker',
                'is_active' => true
            ],
            [
                'role_id' => $user_detail4->role_id,
                'role_name' => 'User',
                'is_active' => true
            ],
        ]);
    }
}
