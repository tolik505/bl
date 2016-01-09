#!/bin/bash

git status
git fetch -v origin
git checkout master
git pull origin master
composer install

./yii cache/flush-all

echo "DONE"
