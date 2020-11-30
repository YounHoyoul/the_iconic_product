<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Product\ProductService;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductServiceInterface;
use App\Services\ProductClient\ProductClientService;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\ProductClient\ProductClientServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductClientServiceInterface::class, ProductClientService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
