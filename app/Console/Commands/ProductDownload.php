<?php

namespace App\Console\Commands;

use App\Services\ProductClient\ProductClientServiceInterface;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Console\Command;

class ProductDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'download all products';

    /**
     * @ProductClientServiceInterface
     */
    private $client;

    /**
     * @ProductServiceInterface
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductClientServiceInterface $client, ProductServiceInterface $service)
    {
        parent::__construct();

        $this->client = $client;
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $next = config("product.live-endpoint") . config("product.serch-url");
        do {
            try {
                echo ("{$next}\n");
                $productDto = $this->client->getProducts($next);
                $this->service->saveMany($productDto->products()->toArray());
                $next = $productDto->next();
            } catch (Exception $e) {
                echo ($e->getMessage());
            }
        } while ('' != $next);

        return 0;
    }
}
