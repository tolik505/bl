#!/bin/bash

git status
git fetch -v origin
git checkout production
git pull origin production
composer install --no-dev --optimize-autoloader

./yii cache/flush-all

echo "DONE"
