<?php

namespace App\Services\ProductClient;

use App\Services\ProductClient\DTO\ProductDTO;

interface ProductClientServiceInterface
{
    public function getProducts(string $url): ?ProductDTO;

    public function getVideoPreviewUrl(string $sku);
}
