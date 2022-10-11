## TALL Stack Boilerplate

![StyleCI](https://github.styleci.io/repos/522887896/shield?branch=main)

Basic function of a system is here for TailwindCSS, AlpineJs, Livewire and Laravel.

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

```
npm i && npm run dev
```

Now visit `` http://localhost:8000 or http://127.0.0.1:8000 ``

## Admin Credentials
> Email: user@domain.com || Password: secret

## Docker Ports

Ports used in the project:
| Software | Port |
|-------------- | -------------- |
| **nginx** | 80 |
| **phpmyadmin** | 8080 |
| **mysql** | 3306 |
| **php** | 9000 |
| **redis** | 6379 |

## Features (WIP)

 - [ ] Basic Pages: Landing, About, Contact Us
 - [x] Login and Registration
 - [x] Forgot Password, Email Confirmation, Password Reset
 - [ ] Error Pages: 404, 503, 405, 500
 - [x] Basic User functionalities
 - [x] User Roles and Permissions
 - [ ] Sending Email
 - [x] Dashboard
 - [ ] Content Management System
 - [ ] Messages and Inbox
 - [ ] Notifications
 - [x] Laravel X-Components
 - [ ] Social Media Login
 - [ ] Import and Export (Excel)
 - [ ] Generate Printable Files (PDF)

## Versions

-   TailwindCSS - 3.0
-   Livewire - 2.0
-   Laravel - 9.0
-   AlpineJs - 3.0

## Useful Commands

### PHP-CS-FIXER
```
composer format app
```