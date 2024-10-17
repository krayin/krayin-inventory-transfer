<?php

namespace Webkul\InventoryTransfer\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Prettus\Repository\Criteria\RequestCriteria;
use Webkul\InventoryTransfer\Http\Resources\ProductResource;
use Webkul\Product\Repositories\ProductRepository;

class WarehouseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ProductRepository $productRepository) {}

    /**
     * Search location results
     */
    public function products(int $id): JsonResource
    {
        $products = $this->productRepository
            ->with(['inventories' => function ($query) use ($id) {
                $query->where('warehouse_id', $id)
                    ->where('in_stock', '>', 0);
            }])
            ->pushCriteria(app(RequestCriteria::class))
            ->select('products.*')
            ->leftJoin('product_inventories', 'products.id', '=', 'product_inventories.product_id')
            ->where('product_inventories.in_stock', '>', 0)
            ->where('product_inventories.warehouse_id', $id)
            ->distinct('products.id')
            ->get();

        return ProductResource::collection($products);
    }
}
