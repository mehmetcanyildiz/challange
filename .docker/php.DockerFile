FROM php:8.1-fpm

RUN apt-get update && apt-get install -y git zip unzip supervisor cron nano
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./.docker/ext/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD ./.docker/ext/crons /etc/cron.d/crons

RUN chmod 0644 /etc/cron.d/crons

WORKDIR /var/www

CMD /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf