<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;

$cat = Category::firstOrCreate(['slug' => 'camilan'], ['name' => 'Camilan']);

Product::firstOrCreate(
    ['slug' => 'mendoan'],
    [
        'name' => 'Mendoan',
        'category_id' => $cat->id,
        'description' => 'Mendoan hangat dan gurih khas Kedai Marjuki\'S disajikan pas untuk camilan santai.',
        'price' => 1500,
        'stock' => 50,
        'status' => 'available',
        'image' => null,
    ]
);

Product::firstOrCreate(
    ['slug' => 'tahu-bakso'],
    [
        'name' => 'Tahu Bakso',
        'category_id' => $cat->id,
        'description' => 'Tahu bakso lembut isi olahan daging pilihan yang nikmat dan gurih.',
        'price' => 2500,
        'stock' => 50,
        'status' => 'available',
        'image' => null,
    ]
);

Product::firstOrCreate(
    ['slug' => 'bakwan-jagung'],
    [
        'name' => 'Bakwan Jagung',
        'category_id' => $cat->id,
        'description' => 'Bakwan jagung renyah dan manis gurih racikan bumbu khas rumahan Kedai Marjuki\'S.',
        'price' => 1500,
        'stock' => 50,
        'status' => 'available',
        'image' => null,
    ]
);

echo "CAMILAN_DB_SEEDED_SUCCESSFULLY\n";
