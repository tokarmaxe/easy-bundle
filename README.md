EasyBundle
=======

*How to run it?*
-----------

1. Clone the project 

2. Open terminal in the root project directory

3. Change your directory to .docker and up docker-compose

```
cd docker
docker-compose up -d --build
```

4. Composer install required

```
docker-compose exec php-fpm composer install
```

5. *The site should be available by next address*
```
http://localhost:8080
```

*How to run tests?*
-----------

```
docker-compose exec php-fpm ./vendor/bin/phpunit
docker-compose exec php-fpm ./vendor/bin/phpunit tests/Unit/Command
```