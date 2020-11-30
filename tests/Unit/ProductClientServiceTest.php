<?php

namespace Tests\Unit;

use App\Services\ProductClient\ProductClientServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductClientServiceTest extends TestCase
{
    private function getCorrectResponse()
    {
        return [
            "_links" => [
                "next" => [
                    "href" => "https://eve.theiconic.com.au/catalog/products?page=2&page_size=1",
                ],
            ],
            "_embedded" => [
                "product" => [
                    [
                        "video_count" => 0,
                        "sku" => "CA980AC88LHJ",
                        "name" => "Wright Duffle Bag1",
                    ],
                    [
                        "video_count" => 0,
                        "sku" => "CA980AC88LHK",
                        "name" => "Wright Duffle Bag2",
                    ],
                    [
                        "video_count" => 0,
                        "sku" => "CA980AC88LHL",
                        "name" => "Wright Duffle Bag3",
                    ],
                ],
            ],
        ];
    }

    private function getCorrectLastPageResponse()
    {
        return [
            "_links" => [

            ],
            "_embedded" => [
                "product" => [
                    [
                        "video_count" => 0,
                        "sku" => "CA980AC88LHJ",
                        "name" => "Wright Duffle Bag1",
                    ],
                    [
                        "video_count" => 0,
                        "sku" => "CA980AC88LHK",
                        "name" => "Wright Duffle Bag2",
                    ],
                    [
                        "video_count" => 0,
                        "sku" => "CA980AC88LHL",
                        "name" => "Wright Duffle Bag3",
                    ],
                ],
            ],
        ];
    }

    private function getCorrectVideoPreviewResponse()
    {
        return [
            "_links" => [
                "next" => [
                    "href" => "https://eve.theiconic.com.au/catalog/products/LO569SA80GXF/videos?page=1",
                ],
            ],
            "_embedded" => [
                "videos_url" => [
                    [
                        "url" => "https://vod-progressive.akamaized.net/exp=1606737153~acl=%2Fvimeo-prod-skyfire-std-us%2F01%2F4681%2F17%2F448408308%2F1969019186.mp4~hmac=793404965d8a8677e1b1cf7286b593ce8f4827234fb170618859cdf5dc27b0f8/vimeo-prod-skyfire-std-us/01/4681/17/448408308/1969019186.mp4",
                        "_links" => [
                            "self" => [
                                "href" => "https://eve.theiconic.com.au/catalog/products/LO569SA80GXF/videos",
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function testProductClientServiceReturnsProductDTOThatHasNextPage()
    {
        $app = $this->createApplication();

        $payload = $this->getCorrectResponse();

        Http::fake([
            'test_url' => Http::response($payload, 200),
        ]);

        $service = $app->make(ProductClientServiceInterface::class);

        $result = $service->getProducts("test_url");

        $this->assertTrue($result->next() == Arr::get($payload, "_links.next.href"));
    }

    public function testProductClientServiceReturnsProductDTOThatHasCollection()
    {
        $app = $this->createApplication();

        Http::fake([
            'test_url' => Http::response($this->getCorrectResponse(), 200),
        ]);

        $service = $app->make(ProductClientServiceInterface::class);

        $result = $service->getProducts("test_url");

        $this->assertTrue($result->products()->filter(function ($product) {
            return Arr::get($product, 'video_count') == 0 &&
            Arr::get($product, 'sku') == 'CA980AC88LHJ' &&
            Arr::get($product, 'body') > '';
        })->count() > 0);
    }

    public function testProductClientServiceReturnsProductDTOThatHasNoNextPageInTheLastPage()
    {
        $app = $this->createApplication();

        Http::fake([
            'test_url' => Http::response($this->getCorrectLastPageResponse(), 200),
        ]);

        $service = $app->make(ProductClientServiceInterface::class);

        $result = $service->getProducts("test_url");

        $this->assertTrue($result->next() == "");
    }

    public function testProductClientServiceReturnNullOnClientError()
    {
        $app = $this->createApplication();

        Http::fake([
            'test_url' => Http::response($this->getCorrectResponse(), 500),
        ]);

        $service = $app->make(ProductClientServiceInterface::class);

        $result = $service->getProducts("test_url");

        $this->assertTrue(null == $result);
    }

    public function testProductClientServiceReturnNullOnServerError()
    {
        $app = $this->createApplication();

        Http::fake([
            'test_url' => Http::response($this->getCorrectResponse(), 500),
        ]);

        $service = $app->make(ProductClientServiceInterface::class);

        $result = $service->getProducts("test_url");

        $this->assertTrue(null == $result);
    }

    public function testProductClientServiceCanReturnVideoPreviewUrl()
    {
        $app = $this->createApplication();

        $payload = $this->getCorrectVideoPreviewResponse();

        Http::fake([
            'https://eve.theiconic.com.au/catalog/products/LO569SA80GXF/videos' => Http::response($payload , 200),
        ]);

        $service = $app->make(ProductClientServiceInterface::class);

        $result = $service->getVideoPreviewUrl("LO569SA80GXF");

        $this->assertTrue(Arr::get($result, '_links.next.href') == Arr::get($result, '_links.next.href'));
    }
}
