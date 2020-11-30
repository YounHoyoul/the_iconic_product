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
        $limit = config("product.limit", 100000);
        $chunk_size = config('product.chunk_size', 10);

        foreach ($this->service->getByVideoCount($limit)->chunk($chunk_size) as $products) {
            foreach ($products as $product) {
                echo (".");
                try {
                    $response = $this->client->getVideoPreviewUrl($product->sku);
                    $payload = Arr::get($response, "_embedded.videos_url");
                    if (null === $payload || count($payload) == 0) {
                        $this->service->update($product->id, [
                            "video_count" => 0,
                            'video_body' => null,
                        ]);
                        continue;
                    }
                    $this->service->addVideourlToProduct($product, $payload);
                } catch (Exception $e) {
                    echo ($e->getMessage());
                }
            }
        };
    }
}
