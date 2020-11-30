<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{
    /**
     * @ProductRepositoryInterface
     */

    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function saveMany(array $data): bool
    {
        return $this->repository->saveMany($data);
    }

    public function saveAll($fh): bool
    {
        return $this->repository->saveAll($fh);
    }

    public function getByVideoCount(int $limit): Collection
    {
        return $this->repository->getByVideoCount($limit);
    }

    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function addVideourlToProduct(Product $product, array $video): bool
    {
        $productJson = json_decode($product->body, true);

        $productJson['videos_url'] = $video;

        $this->update($product->id, [
            'video_body' => json_encode($productJson),
        ]);

        return true;
    }
}
