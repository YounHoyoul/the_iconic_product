<?php

namespace App\Services\ProductClient\DTO;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductDTO
{
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function products(): Collection
    {
        return collect(Arr::get($this->response, "_embedded.product"))->map(function ($item) {
            return [
                'sku' => Arr::get($item, 'sku'),
                'video_count' => Arr::get($item, 'video_count'),
                'body' => json_encode($item),
            ];
        });
    }

    public function next(): string
    {
        return Arr::get($this->response, "_links.next.href") ?? '';
    }
}
