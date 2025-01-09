## TALL Stack Boilerplate

![StyleCI](https://github.styleci.io/repos/522887896/shield?branch=main)

Basic function of a api system.

## Install application
```
git clone https://github.com/rochi88/tall_boilerplate.git
cp .env.example .env
composer update
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

## Features (WIP)

 - [x] Login and Registration

## TALL Versions

-   Laravel - 11.x
-   Laravel Sanctum - 4.x
-   Tymon jwt-auth - 2.x

