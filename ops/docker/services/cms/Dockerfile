FROM alpine:3.12

RUN apk add --no-cache \
supervisor nginx \
php7-cli php7-fpm php7-ctype php7-curl php7-dom php7-gettext php7-iconv php7-intl php7-mbstring php7-mysqli php7-opcache php7-session php7-simplexml php7-tokenizer php7-xml

COPY tmp /application
COPY etc/supervisor.ini /etc/supervisor.d/99-cms.ini
COPY etc/nginx.conf /etc/nginx/conf.d/default.conf
COPY entrypoint.sh /entrypoint.sh

RUN mkdir -p /run/nginx && \
sed -i -e 's/;date.timezone =/date.timezone = Europe\/Bratislava/g' /etc/php7/php.ini && \
sed -i -e 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/g' /etc/php7/php-fpm.d/www.conf && \
chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]
