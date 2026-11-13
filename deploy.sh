#!/usr/bin/env bash

set -euo pipefail

cd "$(dirname "$0")"

COMPOSER_BIN="${COMPOSER_BIN:-composer2}"

if ! command -v "$COMPOSER_BIN" >/dev/null 2>&1; then
    COMPOSER_BIN=composer
fi

"$COMPOSER_BIN" install --no-dev --optimize-autoloader --no-interaction

php artisan migrate --force
php artisan db:seed --class='Database\Seeders\AdminUserSeeder' --force
php artisan storage:link --force || true
php artisan optimize

echo "Deploy concluído."
