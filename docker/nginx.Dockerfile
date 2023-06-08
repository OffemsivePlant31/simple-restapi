FROM nginx
COPY . /var/www/
COPY ./docker/config/nginx/conf.d/ /etc/nginx/conf.d/
