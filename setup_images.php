<?php
// Create the items directory in storage/app/public
$storagePath = 'c:/xampp/htdocs/prototype-kimpee-laravel/storage/app/public/items';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
    echo "Created directory: $storagePath\n";
}

// Source images from public/uploads
$sourcePath = 'c:/xampp/htdocs/prototype-kimpee-laravel/public/uploads';
$files = glob($sourcePath . '/*.jpg');

echo "Copying " . count($files) . " files to storage...\n";

foreach ($files as $file) {
    $filename = basename($file);
    $destFile = $storagePath . '/' . $filename;
    
    if (copy($file, $destFile)) {
        echo "Copied: $filename\n";
    } else {
        echo "Failed to copy: $filename\n";
    }
}

echo "\nDone! Files in storage/app/public/items:\n";
$storageFiles = glob($storagePath . '/*.jpg');
foreach ($storageFiles as $f) {
    echo "  - " . basename($f) . "\n";
}
