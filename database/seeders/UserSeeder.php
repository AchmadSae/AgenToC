<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\GenerateId;
use App\Models\User;
use App\Models\UserDetailModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Insert roles (buat sekali saja, id manual agar konsisten)
        DB::table('roles')->insert([
            ['role_id' => 'RADMIN', 'role_name' => 'admin'],
            ['role_id' => 'RUSER', 'role_name' => 'user'],
            ['role_id' => 'RWORKER', 'role_name' => 'worker'],
        ]);

        // Insert user_detail
        $user_detail1 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'address_detail' => 'Jl. Kebon Jeruk No. 1',
            'phone_number' => '08123456789',
            'postal_code' => '12345',
            'credit_number' => '1234567890123456',
            'balance_coins' => 10,
        ]);

        $user_detail2 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'address_detail' => 'Jl. Kebon Jeruk No. 2',
            'phone_number' => '0845678901',
            'postal_code' => '12345',
            'credit_number' => '26192891012345678',
            'balance_coins' => 10,
        ]);

        $user_detail3 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'address_detail' => 'Jl. Kebon Jeruk No. 3',
            'phone_number' => '0845678902',
            'postal_code' => '13345',
            'credit_number' => '26131891012345678',
            'balance_coins' => 5,
        ]);

        $user_detail4 = UserDetailModel::create([
            'id' => GenerateId::generateWithDate('UD'),
            'address_detail' => 'Jl. Kebon Jeruk No. 4',
            'phone_number' => '624845678901',
            'postal_code' => '13345',
            'credit_number' => '26131891012345679',
            'balance_coins' => 5,
        ]);

        // Insert users
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

        // Insert user_detail_roles
        DB::table('user_detail_roles')->insert([
            ['user_detail_id' => $user_detail1->id, 'role_id' => 'RADMIN', 'is_active' => true],
            ['user_detail_id' => $user_detail1->id, 'role_id' => 'RUSER', 'is_active' => true],
            ['user_detail_id' => $user_detail2->id, 'role_id' => 'RUSER', 'is_active' => true],
            ['user_detail_id' => $user_detail2->id, 'role_id' => 'RADMIN', 'is_active' => true],
            ['user_detail_id' => $user_detail3->id, 'role_id' => 'RWORKER', 'is_active' => true],
            ['user_detail_id' => $user_detail4->id, 'role_id' => 'RUSER', 'is_active' => true],
        ]);
    }
}
