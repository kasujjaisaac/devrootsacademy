<?php
// TEMPORARY — delete after use
$base = '/home/devruzww/public_html';

$checks = [
    'app/Models/Instructor.php',
    'app/Models/instructor.php',       // wrong casing
    'app/models/Instructor.php',       // wrong dir casing
    'app/Models/Student.php',
    'app/Models/Course.php',
    'app/Models/Payment.php',
    'app/Models/Enrollment.php',
];

echo "<pre>\n";
echo "Base: $base\n\n";

foreach ($checks as $rel) {
    $full = $base . '/' . $rel;
    if (file_exists($full)) {
        $perms = substr(sprintf('%o', fileperms($full)), -4);
        echo "✅ EXISTS  ($perms)  $rel\n";
    } else {
        echo "❌ MISSING             $rel\n";
    }
}

echo "\n--- Actual files in app/Models/ ---\n";
$dir = $base . '/app/Models';
if (is_dir($dir)) {
    foreach (scandir($dir) as $f) {
        if ($f === '.' || $f === '..') continue;
        $perms = substr(sprintf('%o', fileperms("$dir/$f")), -4);
        echo "  $perms  $f\n";
    }
} else {
    echo "❌ Directory app/Models does not exist\n";
    echo "Checking app/ contents:\n";
    $appDir = $base . '/app';
    if (is_dir($appDir)) {
        foreach (scandir($appDir) as $f) {
            if ($f === '.' || $f === '..') continue;
            echo "  $f\n";
        }
    }
}
echo "</pre>";
