FROM php:7.3.3-cli

EXPOSE 8000

RUN apt-get update && apt-get install -y git zlib1g-dev libzip-dev gnupg2
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') \
	{ echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN	php composer-setup.php
RUN	php -r "unlink('composer-setup.php');"
RUN	mv composer.phar /usr/local/bin/composer
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
RUN echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.bashrc
RUN git clone http://github.com/creationix/nvm.git /root/.nvm;
RUN chmod -R 777 /root/.nvm/;
RUN bash /root/.nvm/install.sh;
RUN bash -i -c "nvm ls-remote";
RUN bash -i -c "nvm install 10.13.0";

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get install apt-transport-https ca-certificates -y
RUN apt-get install libpng-dev -y --no-install-recommends
RUN apt-get update && apt-get install --no-install-recommends yarn
