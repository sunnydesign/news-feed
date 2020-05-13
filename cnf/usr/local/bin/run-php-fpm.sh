#!/bin/bash

env | perl -pe 's/(.+?)=(.*)/env[\1]=\$\1/' > /etc/php/7.4/fpm/pool.d/env.env

#cd /var/www/api.xsolla.com/
#/usr/bin/php ./migrate.php >> /var/log/migrate.log

/usr/sbin/php-fpm7.4 -F -y /etc/php/7.4/fpm/php-fpm.conf
