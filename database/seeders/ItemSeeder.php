<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Delete all items permanently
        Item::query()->delete();
        
        echo "✅ All items have been deleted from the database.\n";
    }
}
