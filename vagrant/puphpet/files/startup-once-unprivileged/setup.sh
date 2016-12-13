#!/bin/bash

cd /var/www/orachat

composer install -q
touch database/app.sqlite