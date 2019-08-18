FROM amazeeio/php:7.1-cli-drupal

COPY composer.json /app/

RUN composer install


