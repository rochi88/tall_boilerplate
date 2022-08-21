# Install application
```
git clone https://github.com/rochi88/lara_lab.git
cp .env.example .env
composer update
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

```
npm i
npm run dev
```

Now visit `` http://localhost:8000 or http://127.0.0.1:8000 ``

# Admin Credentials
> Email: user@domain.com || Password: password