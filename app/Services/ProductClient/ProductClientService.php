<?php

namespace App\Services\ProductClient;

use App\Services\ProductClient\DTO\ProductDTO;
use Illuminate\Support\Facades\Http;

class ProductClientService implements ProductClientServiceInterface
{
    public function getProducts(string $url): ?ProductDTO
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($url);

            if ($response->ok()) {
                return new ProductDTO($response->json());
            }
        } catch (Exception $e) {

        }

        return null;
    }

    public function getVideoPreviewUrl(string $sku)
    {
        try {
            $url = config('product.live-endpoint') . str_replace("{sku}", $sku, config('product.video-preview-url'));

            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($url);

            if ($response->ok()) {
                return $response->json();
            }
        } catch (Exception $e) {

        }

        return null;
    }
}
