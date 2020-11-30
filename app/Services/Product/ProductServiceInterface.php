<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    public function saveMany(array $data): bool;

    public function saveAll($fh): bool;

    public function getByVideoCount(): Collection;

    public function update(int $id, array $data): bool;

    public function addVideourlToProduct(Product $product, array $video): bool;
}
