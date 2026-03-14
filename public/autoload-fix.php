<?php
/**
 * TEMPORARY — delete this file immediately after use.
 * Access once via: https://devroots.ac.ug/autoload-fix.php
 */

// Basic protection — change or remove after use
$token = $_GET['token'] ?? '';
if ($token !== 'fix-autoload-2025') {
    http_response_code(403);
    die('Forbidden');
}

$root = dirname(__DIR__);
$output = [];

// 1. Regenerate Composer autoloader (classmap + PSR-4)
chdir($root);
exec('composer dump-autoload --optimize 2>&1', $output, $code);

// 2. Clear Laravel caches
exec('php artisan optimize:clear 2>&1', $output, $code2);

echo '<pre>';
echo "=== composer dump-autoload --optimize ===\n";
echo htmlspecialchars(implode("\n", $output));
echo "\n\nDone. DELETE this file now.\n";
echo '</pre>';
