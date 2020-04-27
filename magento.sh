#!/bin/bash

find . -type f -exec chmod 644 {} \; && 
find . -type d -exec chmod 755 {} \; && 
find ./var -type d -exec chmod 777 {} \; && 
find ./pub/media -type d -exec chmod 777 {} \; && 
find ./pub/static -type d -exec chmod 777 {} \; &&
chmod 777 ./app/etc && 
chmod 644 ./app/etc/*.xml

php bin/magento setup:upgrade
composer install
chmod -R 777 generated var
chmod 777 app/etc/env.php
