<?php
// Debug file untuk memeriksa konfigurasi server

echo "<h1>Debug Info - Server Configuration</h1>";

// Test basic PHP functionality
echo "<h2>PHP Info</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

// Test server variables
echo "<h2>Server Variables</h2>";
echo "<pre>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "<br>";
echo "Path to this file: " . __FILE__ . "<br>";
echo "</pre>";

// Test directory structure
echo "<h2>Directory Structure</h2>";
echo "<pre>";
echo "Current Directory: " . getcwd() . "<br>";
$parentDir = dirname(__DIR__);
echo "Parent Directory: " . $parentDir . "<br>";
echo "Files in parent directory:<br>";
$files = scandir($parentDir);
print_r($files);
echo "</pre>";

// Test if CodeIgniter files exist
echo "<h2>CodeIgniter Files</h2>";
echo "<pre>";
$ciFiles = [
    'app/Config/App.php' => file_exists($parentDir . '/app/Config/App.php'),
    'app/Config/Routes.php' => file_exists($parentDir . '/app/Config/Routes.php'),
    'system/CodeIgniter.php' => file_exists($parentDir . '/system/CodeIgniter.php'),
    'vendor/autoload.php' => file_exists($parentDir . '/vendor/autoload.php')
];
foreach ($ciFiles as $file => $exists) {
    echo $file . ': ' . ($exists ? 'Exists' : 'Does not exist') . "<br>";
}
echo "</pre>"; 