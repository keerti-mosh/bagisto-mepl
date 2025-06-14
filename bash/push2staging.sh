#!/bin/bash

./vendor/bin/phpunit

if [ $? -ne 0 ]; then
    echo 'PHP Unit Failed'
    #exit
else
    echo 'PHP Unit Passed'
fi

cb=$(git symbolic-ref --short HEAD)

git pull origin live
git pull origin staging

npm run production
git add public/yn/*
git add public/ar/*
git add public/mix-manifest.json
git commit -m "auto commit public files"

git checkout staging

git merge $cb

git push origin staging

git checkout $cb

git status
