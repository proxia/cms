FROM alpine:edge

RUN apk add --no-cache \
composer \
php7-cli php7-fpm php7-apcu php7-ctype php7-curl php7-dom php7-gettext php7-iconv php7-intl php7-mbstring php7-mysqli php7-opcache php7-session php7-simplexml php7-tokenizer php7-xml

COPY ./entrypoint.sh /entrypoint.sh

RUN \
chmod +x /entrypoint.sh && \
sed -i -e 's/;daemonize = yes/daemonize = no/g' /etc/php7/php-fpm.conf && \
sed -i -e 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/g' /etc/php7/php-fpm.d/www.conf && \
sed -i -e 's/;date.timezone =/date.timezone = Europe\/Bratislava/g' /etc/php7/php.ini

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
