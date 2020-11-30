#How to set up
```
composer install
cp .env.example .env
```

modify the .env fle to add sqlite
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/the/databse/file/
```

#How to run the console command
```
php artisan product::all
```

#How to run unit test
```
./vendor/bin/phpunit
```