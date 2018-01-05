ZendFinal
=========

ZendFinal is a project using Zend Framework.

## How to install

copy ``docker-compose.yml.dist`` to ``docker-compose.yml``

copy ``.env.dist`` to ``.env``

Replace what you want to

### With Docker-Compose

Run ``docker-compose up`` to build the network

Then run 

* ``docker-compose exec php-fpm composer install`` To install composer dependencies
* ``docker-compose exec php-fpm vendor/bin/doctrine-module orm:schema:update --force`` to build the database schema

### Without Docker-Compose

Run

* ``composer install`` To install composer dependencies
* ``./vendor/bin/doctrine-module orm:schema:update --force`` to build the database schema

### Finally

You are ready to go !

