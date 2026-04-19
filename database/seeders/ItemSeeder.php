<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // ⚠️ Uncomment if you want to reset items every seed
        // Item::truncate();

        $imageFiles = Storage::disk('public')->files('images');

        $reporters = ['Benjie', 'Atan', 'Jasmin', 'Sey', 'Guko', 'Hazel', 'Carl', 'Grace', 'Joylene'];

        $locations = [
            'school library', 'classroom building', 'cafeteria', 'gym', 'parking lot', 'hallway',
            'sports field', 'student center', 'computer lab', 'canteen', 'auditorium', 'gate',
            'old covered court', 'basketball court', 'school gate', 'classroom 305', 'dormitory lobby',
            'admin building', 'soccer field', 'roof deck', 'clinic area', 'printing center',
            'flagpole area', 'science laboratory', 'music room', "principal's office", 'student council room'
        ];

        $lostItems = 0;
        $foundItems = 0;

        $user = User::first();

        foreach ($imageFiles as $index => $imagePath) {

            $filename = basename($imagePath);
            $reporter = $reporters[$index % count($reporters)];
            $location = $locations[$index % count($locations)];

            $itemName = $this->generateItemName($filename, $index);
            $category = $this->generateCategory($filename);
            $status = ($index % 2 === 0) ? 'lost' : 'found';

            ($status === 'lost') ? $lostItems++ : $foundItems++;

            $description = $this->generateDescription($itemName, $reporter, $location, $status, $filename);

            Item::create([
                'reporter_name' => $reporter,
                'item_name' => $itemName,
                'description' => $description,
                'category' => $category,
                'status' => $status,
                'image' => $imagePath,
                'date_found' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'reported_by' => $user ? $user->id : 1,
            ]);
        }

        echo "✅ Seeded " . count($imageFiles) . " items: {$lostItems} lost, {$foundItems} found.\n";
    }

    private function generateItemName(string $filename, int $index): string
    {
        $name = $this->detectItemFromFilename($filename, $index);
        return $this->censorProfanity($name);
    }

    private function detectItemFromFilename(string $filename, int $index): string
    {
        $lower = strtolower($filename);

        // Advanced mappings for precise image matching
        $mappings = [
            'anker' => 'Anker PowerCore 20100 Power Bank',
            'adidas samba' => 'Adidas Samba OG White Black Shoes',
            'jbl charge' => 'JBL Charge 5 Bluetooth Speaker',
            'iphone 15 pro' => 'iPhone 15 Pro Max Natural Titanium',
            'iphone 13' => 'iPhone 13',
            'lululemon' => 'Lululemon Water Bottle',
            'puma speedcat' => 'Puma Speedcat Shoes',
            'asics shoes' => 'Asics Shoes',
            'black shoes' => 'Black Shoes',
            'gray slipper' => 'Gray Slipper',
            'brown slipper' => 'Brown Slipper',
            'realme buds' => 'Realme Buds T110 Wireless Earbuds',
            'jm080b thermo' => 'JM080B Thermo Bottle',
            'ny caps yankees' => 'NY Yankees Classic Snapback Cap',
            'polo ralph lauren' => 'Polo Ralph Lauren Sport Cap Dark Brown',
            'black-nike hat' => 'Black Nike Hat',
            'white-nike hat' => 'White Nike Hat',
            'hellfire club shirt' => 'Hellfire Club Shirt',
            'junji ito' => 'Junji Ito Tomie Redux T-Shirt',
            'totoro messenger bag' => 'Totoro Messenger Bag',
            'nike sportswear rucksack' => 'Nike Heritage Rucksack Backpack',
            'dep op sunglasses' => "Women's Sunglasses",
            'skate board' => 'Skateboard',
            'blood boiler' => 'Blood Boiler Item'
        ];

        foreach ($mappings as $key => $name) {
            if (str_contains($lower, $key)) {
                return $name;
            }
        }

        // Smart filename parsing for all others
        $namePart = pathinfo($filename, PATHINFO_FILENAME);
$clean = preg_replace('/[._\-(),\']+/', ' ', $namePart);
$clean = preg_replace('/\\s+/', ' ', trim($clean));
        $parts = explode(' ', $clean);
        $mainParts = array_slice(array_filter($parts), 0, 6);
        $parsedName = ucwords(implode(' ', $mainParts));

        // Fallback for random hashes
        if (preg_match('/^[a-f0-9]{20,}/i', $namePart)) {
            $fallbackItems = [
                'Unknown Gadget', 'Personal Accessory', 'Electronic Device',
                'Clothing Item', 'Footwear', 'Headwear'
            ];
            return $fallbackItems[$index % count($fallbackItems)];
        }

        return $parsedName ?: 'Lost Item';
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

        if (preg_match('/key/', $lower)) return 'Accessories';
        if (preg_match('/shoes?|slipper|sneakers?|samb|speedcat/', $lower)) return 'Clothing';
        if (preg_match('/fan|headset|buds|speaker|jbl|anker|realme|camera|charger/', $lower)) return 'Gadgets';
        if (preg_match('/bag|rucksack|backpack|totoro/', $lower)) return 'Bags';
        if (preg_match('/cap|hat|yankees|polo|nike hat/', $lower)) return 'Clothing';
        if (preg_match('/bottle|thermo|lululemon/', $lower)) return 'Accessories';
        if (preg_match('/book|notebook|dvd|cd/', $lower)) return 'Documents';
        if (preg_match('/skateboard|skate board/', $lower)) return 'Sports';
        if (preg_match('/sunglasses|shade/', $lower)) return 'Accessories';
        if (preg_match('/shirt|t-shirt/', $lower)) return 'Clothing';

        return 'Others';
    }

    private function generateDescription(string $itemName, string $reporter, string $location, string $status, string $filename): string
    {
        $prefix = ($status === 'lost') ? 'Lost near' : 'Found at';
        $details = $this->extractImageDetails($filename);
        return "{$prefix} {$location}. {$itemName}. Details: {$details}. Reported by {$reporter}.";
    }

    private function extractImageDetails(string $filename): string
    {
        $lower = strtolower($filename);
        $details = [];

        if (preg_match('/(black|white|gray|brown|red)/i', $lower, $m)) $details[] = ucfirst($m[1]) . ' color';
        if (str_contains($lower, 'bluetooth') || str_contains($lower, 'wireless')) $details[] = 'Wireless/Bluetooth';
        if (str_contains($lower, 'iphone')) $details[] = 'iPhone compatible';
        if (str_contains($lower, 'shoes|slipper')) $details[] = 'Footwear';
        if (str_contains($lower, 'hat|cap')) $details[] = 'Headwear';
        if (str_contains($lower, 'case')) $details[] = 'Phone case';
        if (str_contains($lower, 'mah')) $details[] = 'High capacity battery';
        if (str_contains($lower, 'snapback')) $details[] = 'Snapback style';

        return implode(', ', $details) ?: 'Clear view in image';
    }
}

