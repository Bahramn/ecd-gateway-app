FROM nginx:1.15-alpine

MAINTAINER Bahram Nedaei <bahramnedaei@gmail.com>

COPY nginx.conf /etc/nginx/
COPY sites/ecd-gateway.conf /etc/nginx/sites-available/

ARG PHP_UPSTREAM_SERVICE=php-fpm
ARG PHP_UPSTREAM_PORT=9000

# Install necessary packages
RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash tzdata \
    && adduser -D -H -u 1000 -s /bin/bash www-data


# Set timezon to Tehran
ENV TZ Asia/Tehran

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_SERVICE}:${PHP_UPSTREAM_PORT}; }" >> /etc/nginx/conf.d/upstream.conf

RUN rm /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/ecd-gateway && chown www-data:www-data -R /var/www

CMD ["nginx"]

EXPOSE 80
