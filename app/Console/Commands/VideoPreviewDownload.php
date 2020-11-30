<?php

namespace App\Console\Commands;

use App\Services\ProductClient\ProductClientServiceInterface;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class VideoPreviewDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:video-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download video url';

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
        dd($this->service->getByVideoCount()->take(10));
        foreach ($this->service->getByVideoCount()->chunk(10) as $products) {
            foreach ($products as $product) {
                echo (".");
                $response = $this->client->getVideoPreviewUrl($product->sku);
                $payload = Arr::get($response, "_embedded.videos_url");
                if (null === $payload || len($payload) == 0) {
                    $this->service->update($product->id, ["video_count" => 0]);
                    continue;
                }
                $this->service->addVideourlToProduct($product, $payload);
            }
        };
    }
}
