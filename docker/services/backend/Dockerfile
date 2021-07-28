FROM alpine:3.13

RUN apk add --no-cache \
composer \
php8 php8-fpm php8-pecl-apcu php8-ctype php8-curl php8-dom php8-gettext php8-iconv php8-intl php8-mbstring php8-mysqli php8-opcache \
php8-session php8-simplexml php8-openssl php8-phar php8-pdo_sqlite php8-tokenizer php8-xml

COPY ./entrypoint.sh /entrypoint.sh

RUN \
unlink /usr/bin/php && ln -s /usr/bin/php8 /usr/bin/php && \
chmod +x /entrypoint.sh && \
sed -i -e 's/;daemonize = yes/daemonize = no/g' /etc/php8/php-fpm.conf && \
sed -i -e 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/g' /etc/php8/php-fpm.d/www.conf && \
sed -i -e 's/;date.timezone =/date.timezone = Europe\/Bratislava/g' /etc/php8/php.ini

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
