<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::truncate();

        $imageFiles = Storage::disk('public')->files('images');
        $reporters = ['Benjie', 'atan', 'jasmin', 'sey', 'guko', 'hazel', 'carl', 'grace', 'joylene'];
        $locations = [
            'school library', 'classroom building', 'cafeteria', 'gym', 'parking lot', 'hallway', 
            'sports field', 'student center', 'computer lab', 'canteen', 'auditorium', 'gate',
            'old covered court', 'basketball court', 'school gate', 'classroom 305', 'dormitory lobby', 
            'admin building', 'soccer field', 'roof deck', 'clinic area', 'printing center',
            'flagpole area', 'science laboratory', 'music room', 'principal's office', 'student council room'
        ];

        $lostItems = 0;
        $foundItems = 0;

        foreach ($imageFiles as $index => $imagePath) {
            $filename = basename($imagePath);
            $reporter = $reporters[$index % count($reporters)];
            $location = $locations[$index % count($locations)];
            
            $itemName = $this->generateItemName($filename, $index);
            $category = $this->generateCategory($filename);
            $status = ($index % 2 === 0) ? 'lost' : 'found';
            
            if ($status === 'lost') $lostItems++;
            else $foundItems++;

            $prefix = ($status === 'lost') ? 'Lost by' : 'Found by';

            $description = $this->generateDescription($itemName, $reporter, $location, $status, $filename);

            Item::create([
                'reporter_name' => $reporter,
                'item_name' => $itemName,
                'description' => $description,
                'category' => $category,
                'status' => $status,
                'image' => $imagePath,
'date_found' => Carbon::today()->format('Y-m-d'),
                'reported_by' => \App\Models\User::first()->id ?? 1,
            ]);

        }

        echo "✅ Seeded " . count($imageFiles) . " items: {$lostItems} lost, {$foundItems} found. Item names matched to actual items from filenames!\n";
    }

    private function generateItemName(string $filename, int $index): string
    {
        $name = $this->detectProfanityAndGenerate($filename, $index); // Use model logic + censor
        return $this->censorProfanity($name);
    }

    private function detectProfanityAndGenerate(string $filename, int $index): string
    {
        $lower = strtolower($filename);
        
        // Specific mappings (expanded)
        if (stripos($filename, 'anker') !== false) return 'Anker Power Bank';
        if (stripos($filename, 'bag') !== false) return 'Canvas Bag';
        if (stripos($filename, 'jbl') !== false) return 'JBL Bluetooth Speaker';
        if (stripos($filename, 'iphone') !== false) return 'iPhone 15';
        if (stripos($filename, 'thermo bottle') !== false) return 'Thermo Bottle';
        if (stripos($filename, 'nike') !== false) return 'Nike Rucksack Backpack';
        if (stripos($filename, 'ny caps') !== false || stripos($filename, 'yankees') !== false || stripos($filename, 'polo') !== false) return 'Baseball Cap';
        if (stripos($filename, 'realme') !== false) return 'Realme Earbuds';
        if (stripos($filename, 'promote') !== false || stripos($filename, 'airbnb') !== false) return 'Airbnb Booklet';
        if (stripos($filename, 'puma') !== false || stripos($filename, 'samb') !== false) return 'Puma Shoes';
        if (stripos($filename, 'asics') !== false) return 'Asics Running Shoes';
        if (stripos($filename, 'lululemon') !== false) return 'Lululemon Water Bottle';
        if (stripos($filename, 'key') !== false || stripos($filename, 'keys') !== false) return 'House Keys';
        if (stripos($filename, 'umbrella') !== false) return 'Compact Umbrella';
        if (stripos($filename, 'shoes') !== false) return 'Athletic Shoes';
        if (stripos($filename, 'fan') !== false) return 'Portable Fan';
        if (stripos($filename, 'note book') !== false || stripos($filename, 'book') !== false || stripos($filename, 'dean') !== false || stripos($filename, 'aiden') !== false || stripos($filename, 'junji') !== false) return 'Notebook';
        if (stripos($filename, 'dvd') !== false || stripos($filename, 'cd') !== false) return 'DVD Holder';

        // Varied fallback for download/hash files - indexed realistic items
        $fallbackItems = ['Wallet', 'Student ID', 'USB Drive', 'Wireless Mouse', 'Headphones', 'Sunglasses', 'Watch', 'Ring', 'Bracelet', 'Calculator', 'Pen Set', 'Laptop Charger', 'Phone Charger', 'Earbuds Case', 'Power Adapter'];
        if (stripos($lower, 'download') !== false || preg_match('/^[a-z0-9]{5,}/i', pathinfo($filename, PATHINFO_FILENAME))) {
            return $fallbackItems[$index % count($fallbackItems)];
        }
        
        // Fallback: first 1-2 words from filename
        $cleanName = preg_replace('/[._\\-(),]+/', ' ', $filename);
        $parts = explode(' ', trim(pathinfo($cleanName, PATHINFO_FILENAME)));
        $name = ucwords(implode(' ', array_slice(array_filter($parts), 0, 2)));
        return $name ?: 'Personal Item';
    }

    private function censorProfanity(string $text): string
    {
        $badWords = ['fuck', 'shit', 'bitch', 'damn', 'ass', 'fucker', 'pussy', 'cock', 'dick'];
        foreach ($badWords as $word) {
            $text = str_ireplace($word, str_repeat('*', strlen($word)), $text);
        }
        return trim($text);
    }

    private function generateCategory(string $filename): string
    {
        $lower = strtolower($filename);
        if (preg_match('/(key|keys|ly2x|o4km)/i', $lower)) return 'Accessories';
        if (preg_match('/shoes/i', $lower)) return 'Clothing';
        if (preg_match('/fan/i', $lower)) return 'Gadgets';
        if (preg_match('/bag|rucksack|backpack/i', $lower)) return 'Bags';
        if (preg_match('/phone|buds|speaker|anker|jbl|iphone|charger|power|usb|adapter|mouse|watch|earbuds/i', $lower)) return 'Gadgets';
        if (preg_match('/cap|nike|clothing|jacket|shoes|towel/i', $lower)) return 'Clothing';
        if (preg_match('/thermo|bottle|umbrella|sunglasses|ring|bracelet/i', $lower)) return 'Accessories';
        if (preg_match('/id|document|book|notebook|pen|calculator|dvd|cd/i', $lower)) return 'Documents';
        return 'Others';
    }

    private function generateDescription(string $itemName, string $reporter, string $location, string $status, string $filename): string
    {
        $statusPrefix = ($status === 'lost') ? 'Lost near' : 'Found at';
        $lowerFile = strtolower($filename);
        
        // Extract color from filename
        $color = '';
        $colorKeywords = ['black', 'white', 'gray', 'brown', 'silver', 'red', 'navy', 'dark'];
        foreach ($colorKeywords as $ck) {
            if (stripos($lowerFile, $ck) !== false) {
                $color = ucfirst($ck) . ' ';
                break;
            }
        }
        
        // Specific details from filename
        $detail = '';
        if (stripos($lowerFile, 'anker') !== false) {
            $detail = 'Anker PowerCore 20100mAh power bank, PowerIQ logo visible';
        } elseif (stripos($lowerFile, 'jbl') !== false || stripos($lowerFile, 'charge') !== false) {
            $detail = 'JBL Bluetooth speaker, rugged fabric grille';
        } elseif (stripos($lowerFile, 'nike rucksack') !== false || stripos($lowerFile, 'totoro messenger bag') !== false || stripos($lowerFile, 'bag') !== false) {
            $detail = $itemName . ', canvas with printed logo';
        } elseif (stripos($lowerFile, 'iphone 15') !== false) {
            $detail = 'iPhone 15 Pro Max, Natural Titanium finish';
        } elseif (stripos($lowerFile, 'realme buds') !== false) {
            $detail = 'Realme Buds T110 earbuds, black charging case';
        } elseif (stripos($lowerFile, 'thermo bottle') !== false || stripos($lowerFile, 'jm080b') !== false || stripos($lowerFile, 'lululemon water bottle') !== false) {
            $detail = 'stainless steel water bottle, leak-proof lid';
        } elseif (preg_match('/(asics|puma.*speedcat|samb.*|adidas.*samba|shoes)/i', $lowerFile)) {
            $detail = 'athletic running shoes, lace-up design';
        } elseif (stripos($lowerFile, 'ny caps') !== false || stripos($lowerFile, 'yankees') !== false || stripos($lowerFile, 'cap') !== false || stripos($lowerFile, 'hat') !== false) {
            $detail = 'snapback baseball cap, embroidered logo';
        } elseif (stripos($lowerFile, 'key') !== false) {
            $detail = 'house keys, metal ring keychain';
        } elseif (stripos($lowerFile, 'dvd') !== false || stripos($lowerFile, 'cd') !== false) {
            $detail = 'DVD/CD holder case, zip closure';
        } elseif (stripos($lowerFile, 'notebook') !== false || stripos($lowerFile, 'note book') !== false || stripos($lowerFile, 'book') !== false) {
            $detail = 'spiral-bound notebook, lined/graph pages';
        } elseif (preg_match('/headset|buds|earbuds/i', $lowerFile)) {
            $detail = 'wireless earbuds/headset, transparent case';
        } elseif (stripos($lowerFile, 'slipper') !== false || stripos($lowerFile, 'shoes') !== false) {
            $detail = 'casual slippers or flip-flops';
        } elseif (stripos($lowerFile, 'mini fan') !== false || stripos($lowerFile, 'fan') !== false) {
            $detail = 'portable USB mini fan, foldable blades';
        } elseif (stripos($lowerFile, 'sunglasses') !== false || stripos($lowerFile, 'shade') !== false) {
            $detail = 'aviator sunglasses, polarized lenses';
        } elseif (stripos($lowerFile, 'skate board') !== false) {
            $detail = 'skateboard deck, grip tape worn';
        } elseif (stripos($lowerFile, 'hellfire club') !== false) {
            $detail = 'Hellfire Club graphic t-shirt';
        } else {
            $detail = $itemName . ', distinctive markings';
        }
        
        return $statusPrefix . ' ' . $location . ', ' . $color . $detail . '.';
    }
}

