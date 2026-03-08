<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;

$items = Item::select('id', 'item_name', 'image', 'status')->get();

echo "Items in database:\n";
echo str_repeat("-", 80) . "\n";

foreach ($items as $item) {
    echo "ID: {$item->id} | Name: {$item->item_name} | Status: {$item->status} | Image: {$item->image}\n";
}
