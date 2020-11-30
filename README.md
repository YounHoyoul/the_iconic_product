# How to set up
## install composer
```
composer install
cp .env.example .env
```

## modify the .env fle to add sqlite
```
DB_CONNECTION=sqlite
DB_DATABASE=/path/the/databse/file/
```

## change the product config
```
vim ./config/product.php
```
```
return [
    'live-endpoint'     => 'https://eve.theiconic.com.au',
    'serch-url'         => '/catalog/products?gender=female&page=6800&page_size=10&sort=popularity',
    'video-preview-url' => '/catalog/products/{sku}/videos',
    'outfile;           => 'out.json',
    'chunk_size'        => 10,
    'limit'             => 10,
];
```

# How to run the console command
```
source file : app\Console\Product.php
```
```
php artisan product:all
```

# How to run unit test
```
./vendor/bin/phpunit
```