<?php

// Ensure Vercel's read-only filesystem doesn't crash Laravel view compilation
$compiledViews = '/tmp/storage/framework/views';
if (!is_dir($compiledViews)) {
    mkdir($compiledViews, 0755, true);
}

// Ensure the ephemeral SQLite database exists on cold starts
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    // Copy the populated database from the repo into /tmp
    $sourceDb = __DIR__ . '/../database/database.sqlite';
    if (file_exists($sourceDb)) {
        copy($sourceDb, $dbPath);
    } else {
        touch($dbPath);
    }
}

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';
