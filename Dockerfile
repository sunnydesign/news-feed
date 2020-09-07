FROM ubuntu
LABEL MAINTAINER=a@thekilo.org

ENV TZ=Asia/Yekaterinburg

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && apt-get -yqq update && apt-get -yqq upgrade && apt-get -yqq install \
        apt-utils \
        nginx \
        libnginx-mod-http-headers-more-filter \
        php-fpm php-bcmath php-curl php-mysql \
        php-mbstring \
        supervisor jq \
        mc \
        composer \
        htop \
    && rm /etc/nginx/sites-enabled/default

COPY ./ /var/www/news-feed/
COPY ./cnf/etc/ /etc/
COPY ./cnf/usr/local/bin/run-php-fpm.sh /usr/local/bin/
COPY ./cnf/root/.config/mc/ /root/.config/mc/

# Allow to include custom php-fpm config, e.g. to set environment variables
RUN echo 'include=/etc/php/7.4/fpm/pool.d/*.env' >> /etc/php/7.4/fpm/php-fpm.conf \
  && chmod +x /usr/local/bin/run-php-fpm.sh

RUN chown -R www-data:www-data /var/www/news-feed \
  && cd /var/www/news-feed \
  && composer install

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]