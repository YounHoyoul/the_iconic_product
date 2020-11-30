<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @var Product
     */
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function saveMany(array $data): bool
    {
        return $this->model->insert($data);
    }

    public function saveAll($fh): bool
    {
        $this->model->orderBy('video_count', 'desc')->chunk(
            config('product.chunk_size', 10), function ($products) use ($fh) {
                foreach ($products as $product) {
                    fwrite($fh, $product->video_body ? $product->video_body : $product->body);
                }
                echo (".");
            });

        return true;
    }

    public function getByVideoCount(int $limit): Collection
    {
        return $this->model->where('video_count', '>', 0)->get();
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }
}
