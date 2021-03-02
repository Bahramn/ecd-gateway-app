FROM php:7.4.14-fpm

MAINTAINER Bahram Nedaei <bahramnedaei@gmail.com>

#
#--------------------------------------------------------------------------
# Software's Installation
#--------------------------------------------------------------------------
#
# Installing tools and PHP extentions using "apt", "docker-php", "pecl",
#

# Install necessary packages
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    libz-dev \
    libssl-dev \
    libmcrypt-dev \
    zip unzip \
    git \
    netbase \
    gnupg \
    gosu \
    ca-certificates \
    sqlite3 \
    libcap2-bin \
    libzip-dev



# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Set timezone
ENV TZ=Asia/Tehran
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

#####################################
# xDebug:
#####################################
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    # Install the xdebug extension
    pecl install xdebug && \
    docker-php-ext-enable xdebug \
;fi

# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#####################################
# PHP REDIS EXTENSION
# Install Php Redis Extension
#####################################
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

#####################################
# Install MongoDB PHP Extension
#####################################
#RUN pecl install mongodb && \
#    docker-php-ext-enable mongodb

#####################################
# Install Postgres PHP Extension
#####################################
#RUN  docker-php-ext-install pdo pdo_pgsql


#
#--------------------------------------------------------------------------
# Application's Installation
#--------------------------------------------------------------------------
#
# Installing the application and performs the commands we need to build it
#

#####################################
# Composer:
#####################################

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

# Create the www-data user
RUN usermod -u 1000 www-data

# Create the web root directory and change the working directory
RUN mkdir -p /var/www && chown www-data:www-data -R /var/www

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

USER root

COPY ./pool.conf /usr/local/etc/php-fpm.d/pool.conf
COPY ./www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./php.ini /usr/local/etc/php-fpm.d/php.ini

RUN rm -r /var/lib/apt/lists/*

WORKDIR /var/www/ecd-gateway

CMD ["php-fpm"]

EXPOSE 9000
