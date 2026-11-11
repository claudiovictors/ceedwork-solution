#!/bin/sh

set -e

cd /var/www/html

mkdir -p \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

if [ ! -L public/storage ]; then
    rm -rf public/storage
    ln -s ../storage/app/public public/storage
fi

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

php artisan storage:link --force >/dev/null 2>&1 || true

echo "A executar migrações..."
php artisan migrate --force

if [ -n "${ADMIN_EMAIL:-}" ] && [ -n "${ADMIN_PASSWORD:-}" ]; then
    php artisan db:seed --class='Database\Seeders\AdminUserSeeder' --force
else
    echo "ADMIN_EMAIL/ADMIN_PASSWORD não definidos: administrador não criado."
fi

echo "A otimizar a aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
