#!/usr/bin/env bash

set -euo pipefail

echo "Starting production deploy tasks..."

php artisan migrate --force
php artisan storage:link || true
php artisan view:clear
php artisan view:cache
php artisan config:clear
php artisan config:cache

echo "Production deploy tasks completed."
