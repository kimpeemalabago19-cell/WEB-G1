<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class FixItemImages extends Command
{
    protected $signature = 'fix:images';
    protected $description = 'Fix item image paths in DB (remove items/ prefix, correct filenames)';

    public function handle()
    {
        $before = Item::where('image', 'like', 'items/%')
                     ->orWhere('image', 'download (1).jpg')
                     ->count();

        // Remove 'items/' prefix
        Item::where('image', 'like', 'items/%')
            ->update(['image' => DB::raw("REPLACE(image, 'items/', '')")]);

        // Fix download filename
        Item::where('image', 'download (1).jpg')
            ->update(['image' => 'download (2).jpg']);

        $after = Item::whereNotNull('image')->count();

        $this->info("✅ Fixed {$before} problematic image paths.");
        $this->info("📁 Total items with images: {$after}");
        $this->info("🔗 Test: http://localhost/Web-G1/storage/items/Mochila.jpg");

        // List all
        $items = Item::select('id', 'item_name', 'image')->get();
        $this->table(['ID', 'Name', 'Image'], $items->toArray());
    }
}
?>

