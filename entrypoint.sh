#!/bin/bash

# Ensure persistent database directory exists
mkdir -p /var/www/html/database

# Check if the persistent SQLite file exists. If not, populate it from the backup.
if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "First time boot: Copying populated database to persistent disk..."
    cp /initial_db.sqlite /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
fi

# Run any necessary migrations just in case (optional)
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground (Render requirement)
exec apache2-foreground
