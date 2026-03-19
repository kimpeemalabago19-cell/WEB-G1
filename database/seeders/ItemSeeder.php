<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::truncate();

        Item::create([
            'reporter_name' => 'Test',
            'item_name' => 'Mochila',
            'description' => 'Backpack from Downloads',
            'category' => 'Bags',
            'status' => 'found',
            'image' => 'Mochila.jpg',
            'reported_by' => 1,
        ]);

        Item::create([
            'reporter_name' => 'Test',
            'item_name' => 'Phone',
            'description' => 'Download phone image',
            'category' => 'Gadgets',
            'status' => 'lost',
            'image' => 'download (2).jpg',
            'reported_by' => 1,
        ]);

        Item::create([
            'reporter_name' => 'Test',
            'item_name' => 'Wallet',
            'description' => 'Weiyinxing wallet',
            'category' => 'Accessories',
            'status' => 'found',
            'image' => 'Weiyinxing New Mini Leather 20 Card Wallet Mini Leather Wallet Business Case Purse Holder RFID Blocking Carteira Masculina Porte Carte - Red.jpg',
            'reported_by' => 1,
        ]);

        echo "✅ 3 items seeded with exact public/storage/items/ files!\n";
    }
}

