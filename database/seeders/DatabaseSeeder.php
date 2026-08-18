<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\QrisSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@marjukis.test'],
            [
                'name' => 'Administrator Kedai',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0882005116301',
                'address' => 'JL. Jomblang Perbalan No 800 Candi, Candisari, Semarang, Jawa Tengah',
            ]
        );

        $buyer = User::firstOrCreate(
            ['email' => 'user@marjukis.test'],
            [
                'name' => 'Pembeli Demo',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'phone' => '081234567890',
                'address' => 'Jl. Pemuda No. 12, Semarang, Jawa Tengah',
            ]
        );

        // 2. Seed Categories
        $catMakanan = Category::firstOrCreate(
            ['slug' => 'makanan'],
            ['name' => 'Makanan']
        );

        $catMinuman = Category::firstOrCreate(
            ['slug' => 'minuman'],
            ['name' => 'Minuman']
        );

        $catCamilan = Category::firstOrCreate(
            ['slug' => 'camilan'],
            ['name' => 'Camilan']
        );

        // 3. Seed Initial Products
        $products = [
            [
                'name' => 'Soto',
                'slug' => 'soto',
                'category_id' => $catMakanan->id,
                'description' => 'Soto ayam segar khas rumahan Kedai Marjuki\'S dengan kuah gurih bening, suwiran daging ayam empuk, soun, daun seledri, irisan tomat, tauge, dan taburan bawang goreng.',
                'price' => 8000,
                'stock' => 25,
                'status' => 'available',
                'image' => null,
            ],
            [
                'name' => 'Rames',
                'slug' => 'rames',
                'category_id' => $catMakanan->id,
                'description' => 'Nasi rames rumahan lengkap dengan mie goreng, kering tempe, ayam opor, dan sayur pecel khas Kedai Marjuki\'S.',
                'price' => 12000,
                'stock' => 30,
                'status' => 'available',
                'image' => 'produk/rames.jpg',
            ],
            [
                'name' => 'Indomie Biasa',
                'slug' => 'indomie-biasa',
                'category_id' => $catMakanan->id,
                'description' => 'Indomie goreng atau kuah dimasak pas dan gurih, disajikan hangat khas kedai.',
                'price' => 6000,
                'stock' => 50,
                'status' => 'available',
                'image' => null,
            ],
            [
                'name' => 'Indomie Telor',
                'slug' => 'indomie-telor',
                'category_id' => $catMakanan->id,
                'description' => 'Indomie pilihan dengan tambahan telur mata sapi / dada rebus nikmat sempurna.',
                'price' => 8000,
                'stock' => 40,
                'status' => 'available',
                'image' => null,
            ],
            [
                'name' => 'Mendoan',
                'slug' => 'mendoan',
                'category_id' => $catCamilan->id,
                'description' => 'Mendoan hangat dan gurih khas Kedai Marjuki\'S disajikan pas untuk camilan santai.',
                'price' => 1500,
                'stock' => 50,
                'status' => 'available',
                'image' => 'produk/mendoan.jpg',
            ],
            [
                'name' => 'Tahu Bakso',
                'slug' => 'tahu-bakso',
                'category_id' => $catCamilan->id,
                'description' => 'Tahu bakso lembut isi olahan daging pilihan yang nikmat dan gurih.',
                'price' => 2500,
                'stock' => 50,
                'status' => 'available',
                'image' => 'produk/tahu-bakso.jpg',
            ],
            [
                'name' => 'Bakwan Jagung',
                'slug' => 'bakwan-jagung',
                'category_id' => $catCamilan->id,
                'description' => 'Bakwan jagung renyah dan manis gurih racikan bumbu khas rumahan Kedai Marjuki\'S.',
                'price' => 1500,
                'stock' => 50,
                'status' => 'available',
                'image' => 'produk/bakwan-jagung.jpg',
            ],
            [
                'name' => 'Es Teh',
                'slug' => 'es-teh',
                'category_id' => $catMinuman->id,
                'description' => 'Es teh manis segar diseduh dari teh pilihan dengan rasa manis yang pas.',
                'price' => 3000,
                'stock' => 100,
                'status' => 'available',
                'image' => 'produk/es-teh.jpg',
            ],
            [
                'name' => 'Es Jeruk',
                'slug' => 'es-jeruk',
                'category_id' => $catMinuman->id,
                'description' => 'Es jeruk peras asli segar dan kaya vitamin C, cocok menemani santapan makanan.',
                'price' => 5000,
                'stock' => 80,
                'status' => 'available',
                'image' => 'produk/es-jeruk.jpg',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['slug' => $p['slug']],
                $p
            );
        }

        // 4. Seed QRIS Setting
        QrisSetting::firstOrCreate(
            ['description' => 'QRIS Kedai Marjuki\'S (Semua e-Wallet & Bank)'],
            [
                'qris_image' => 'qris/qris-sample.svg',
                'is_active' => true,
            ]
        );
    }
}
