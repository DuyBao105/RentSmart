#!/bin/bash
set -e

# Configure Apache listening port based on environment variable (for Render/Railway/Fly.io)
PORT=${PORT:-80}
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Create storage link if not exists
php artisan storage:link || true

# Clear & optimize caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Start Apache in foreground
exec apache2-foreground
