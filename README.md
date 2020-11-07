# TKU Graduate Gown

## Frontend

- jetstream 
- install npm modules

```shell script
npm install && npm run dev
```

- npm watch

```shell script
npm run watch
```


## backend

- install php composer

```shell script
composer update
```

## laravel

- [Laradock](https://laradock.io/)

```shell script
docker-compose up -d nginx mysql phpmyadmin
docker-compose exec workspace zsh
chown -R laradock:laradock /var/www
composer update
```

- update laradock

```shell script
docker-compose build xxx
docker-compose up --force-recreate -d xxx
```

- migrate database with init data
```shell script
php artisan migrate:fresh --seed
```

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
