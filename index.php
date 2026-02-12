<?php
/**
 * This file is an alternative entry point for cPanel hosting
 * when you cannot change the Document Root to the public folder.
 * 
 * If possible, it's better to set Document Root to public/ folder
 * instead of using this file.
 */

// Redirect to public folder
$publicPath = __DIR__ . '/public/index.php';

if (file_exists($publicPath)) {
    require $publicPath;
} else {
    die('Error: public/index.php not found. Please check your installation.');
}
