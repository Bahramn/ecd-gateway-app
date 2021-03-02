FROM node:15.5.1-alpine3.10

MAINTAINER Bahram Nedaei <bahramnedaei@gmail.com>

WORKDIR /var/www/app

RUN apk add git

CMD yarn install && yarn run watch
