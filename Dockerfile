FROM nromero125/php7.3-dokku:php8.1-amd64
#Memory Limit
RUN sed -i "s/memory_limit = .*/memory_limit = 1024M/" /etc/php/8.1/cli/php.ini
#RUN apt-get -y install php8.1-curl php8.1-xml php-mbstring php-xml php-curl php-gd php8.1-gd php-zip php8.1-zip php-mysql

#RUN apt-get -y install php-mbstring php-mysql
# Copy our app into the app folder
COPY . /app
# Create our .env file (we use a commited file called .env.staging)


RUN cp .env.staging .env

RUN chgrp -R www-data /app/storage /app/bootstrap/cache
RUN chmod -R ug+rwx /app/storage /app/bootstrap/cache

# Composer Install
RUN composer self-update
ENV GITHUB_TOKEN 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
RUN composer config --global github-oauth.github.com $GITHUB_TOKEN
RUN composer install --no-interaction
# PHP Artisan Commands
RUN php artisan key:generate
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan storage:link
RUN php artisan migrate:fresh --seed --force
#:fresh --seed