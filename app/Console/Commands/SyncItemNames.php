<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class SyncItemNames extends Command
{
    protected $signature = 'items:sync-names';
    protected $description = 'Update item_names in DB to match their image filenames exactly';

    public function handle()
    {
        $items = Item::whereNotNull('image')->get();

        $updated = 0;
        $errors = [];

        foreach ($items as $item) {
            // Extract filename from image path like 'images/filename.jpg'
            $pathParts = explode('/', $item->image);
            $filename = end($pathParts);
            
            if (str_contains($filename, '.')) {
                $newName = pathinfo($filename, PATHINFO_FILENAME);
                
                if ($item->item_name !== $newName) {
                    $oldName = $item->item_name;
                    $item->item_name = $newName;
                    $item->save();
                    $updated++;
                    $this->info("Updated ID {$item->id}: '{$oldName}' → '{$newName}'");
                }
            } else {
                $errors[] = "ID {$item->id}: Invalid image '{$item->image}'";
            }
        }

        $this->info("\n✅ Synced {$updated} item names successfully.");
        $this->info("❌ Errors: " . count($errors));
        if (!empty($errors)) {
            $this->error(implode("\n", $errors));
        }

        $this->info('Image existence check skipped (no Storage relation).');
    }
}

