FROM nginx:1.12.2

ADD ./.docker/ext/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www
