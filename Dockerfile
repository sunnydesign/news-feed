FROM ubuntu
LABEL MAINTAINER=a@thekilo.ru

ENV TZ=Asia/Yekaterinburg
RUN DEBIAN_FRONTEND="noninteractive" \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && apt-get -yqq update && apt-get -yqq upgrade && apt-get -yqq install \
        apt-utils \
        openssl \
        nginx \
        libnginx-mod-http-headers-more-filter \
        php-fpm php-bcmath php-curl php-mysql \
        php-mbstring \
        supervisor jq \
        mc \
        curl \
        composer \
        htop \
    && rm /etc/nginx/sites-enabled/default

COPY ./src/ /var/www/news-feed/
COPY ./cnf/etc/ /etc/
COPY ./cnf/usr/local/bin/run-php-fpm.sh /usr/local/bin/
COPY ./cnf/root/.config/mc/ /root/.config/mc/

RUN cd /etc/nginx \
    && mkdir ssl \
    && openssl req -x509 -nodes -newkey rsa:2048 -days 365 -keyout /etc/nginx/ssl/nginx.pem -out /etc/nginx/ssl/nginx.crt.pem -subj "/C=RU/ST=Permskiy kray/L=Perm/O=The KILO/OU=IT Department/CN=news-feed.thekilo.org"

RUN chown -R www-data:www-data /var/www/news-feed \
  && cd /var/www/news-feed \
  && composer install

# Allow to include custom php-fpm config, e.g. to set environment variables
RUN echo 'include=/etc/php/7.4/fpm/pool.d/*.env' >> /etc/php/7.4/fpm/php-fpm.conf \
  && chmod +x /usr/local/bin/run-php-fpm.sh

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]