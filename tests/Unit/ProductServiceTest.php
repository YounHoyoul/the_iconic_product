<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductServiceInterface;
use Mockery;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    public function testProductServiceCanAddVideoToProduct()
    {
        $app = $this->createApplication();

        $app->instance(ProductRepositoryInterface::class, Mockery::mock(ProductRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('update')->once();
        }));

        $product = new Product();
        $product->id = 1;
        $product->body = json_encode([
            "video_count" => 0,
            "sku" => "CA980AC88LHJ",
            "name" => "Wright Duffle Bag1",
        ]);

        $videoUrls = [
            [
                "url" => "Test Video Url",
            ],
        ];

        $service = $app->make(ProductServiceInterface::class);

        $result = $service->addVideourlToProduct($product, $videoUrls);

        $this->assertTrue(true);
    }
}
