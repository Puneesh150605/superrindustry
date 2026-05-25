<?php

// ENABLE ERROR REPORTING FOR VERCEL DEBUGGING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// INJECT CRITICAL VERCEL ENVIRONMENT VARIABLES
$envVars = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'true',
    'APP_KEY' => 'base64:ImJSmvDrM3ye57niuDvYwcUZoDlrbDl7qp3uLr0sIWw=',
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'QUEUE_CONNECTION' => 'sync',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => '/tmp/database.sqlite',
    'LOG_CHANNEL' => 'stderr',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
];

foreach ($envVars as $key => $val) {
    putenv("$key=$val");
    $_ENV[$key] = $val;
    $_SERVER[$key] = $val;
}

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
