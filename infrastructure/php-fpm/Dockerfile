FROM php:7.4-fpm-alpine

RUN apk --update --no-cache add git

#COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD php-fpm
EXPOSE 9000