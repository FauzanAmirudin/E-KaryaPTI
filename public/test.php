<?php
echo "<h1>Server Information Test</h1>";
echo "<h2>Server Variables</h2>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

echo "<h2>URL Test</h2>";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "PATH_INFO: " . (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : 'Not set') . "<br>";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

echo "<h2>Environment Test</h2>";
echo "Current directory: " . getcwd() . "<br>";
echo "FCPATH (if defined): " . (defined('FCPATH') ? FCPATH : 'Not defined') . "<br>";
?> 