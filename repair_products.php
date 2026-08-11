<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$defaultCategory = Category::firstOrCreate(['slug' => 'makanan'], ['name' => 'Makanan']);

$products = Product::all();
foreach ($products as $p) {
    if (empty($p->slug) && !empty($p->name)) {
        $p->slug = Str::slug($p->name);
    }
    if (empty($p->category_id)) {
        $p->category_id = $defaultCategory->id;
    }
    $p->save();
}

echo "PRODUCTS_REPAIRED_OK\n";
