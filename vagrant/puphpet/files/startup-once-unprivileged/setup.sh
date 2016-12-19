#!/bin/bash

cd /var/www/orachat

composer install -q
touch database/app.sqlite
cp .env.example .env
php artisan migrate --seed
php artisan key:generate
php artisan jwt:generate