<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Helpers\GenerateId;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class productSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */

    public function run(): void
    {
          DB::table('product_groups')->insert([
                'code' => Constant::PRODUCT_GRAPHIC,
                'value' => 'Visual Graphic Design',
                'terms_and_policy' => 'Layanan
                  Kami menyediakan jasa desain grafis seperti logo, poster, konten sosial media, dan lainnya berdasarkan brief dari klien.

                  Proses

                  Klien wajib memberikan brief lengkap.

                  Lama pengerjaan 2–5 hari kerja.

                  Maksimal 2x revisi (lebih dari itu dikenakan biaya tambahan).

                  Hak Cipta

                  Hak penggunaan desain diberikan setelah pembayaran lunas.

                  Kami boleh menampilkan desain sebagai portofolio, kecuali diminta sebaliknya.

                  Dilarang menjual ulang tanpa izin.

                  Pembayaran

                  Pembayaran bisa full di awal atau DP 50%.

                  Tidak ada refund jika proyek sudah dikerjakan.

                  Pembatalan

                  Pembatalan hanya bisa dilakukan sebelum pengerjaan dimulai.

                  Jika sudah mulai, DP hangus.'

          ]);

          DB::table('products')->insert([
                  'product_group_code' => Constant::PRODUCT_GRAPHIC,
                  'product_code' => GenerateId::generateId('GD', false),
                  'product_name' => 'Logo Design Brand Company',
                  'price' => 230000,
                  'product_description' => '1. sample product description is unique
2. Unlimited revision'
          ]);
    }
}
