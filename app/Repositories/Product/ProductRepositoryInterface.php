<?php

namespace App\Repositories\Product;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function saveMany(array $data): bool;

    public function saveAll($fh): bool;

    public function getByVideoCount(): Collection;

    public function update(int $id, array $data): bool;
}