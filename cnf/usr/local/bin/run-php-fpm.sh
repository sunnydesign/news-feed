#!/bin/bash

env | perl -pe 's/(.+?)=(.*)/env[\1]=\$\1/' > /etc/php/7.4/fpm/pool.d/env.env

/usr/sbin/php-fpm7.4 -F -y /etc/php/7.4/fpm/php-fpm.conf &

cd /var/www/news-feed/
yes | php yii migrate >> /var/log/migrate.log