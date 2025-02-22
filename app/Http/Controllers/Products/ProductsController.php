<?php

namespace App\Http\Controllers\Products;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductListItemResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Category;
use App\Models\Product;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    use HttpResponses, Pagination;

    public function viewAll()
    {
        $products = Product::filter()->paginate(12);

        $productsList = ProductListItemResource::collection($products);

        $data = $this->paginatedData($products, $productsList);

        return $this->success($data);
    }

    public function viewLatest()
    {
        $products = Product::latest()->limit(12)->get();

        $productsList = ProductListItemResource::collection($products);

        return $this->success($productsList);
    }

    public function viewLowCost()
    {
        $products = Product::whereNotNull('discounted_price')
            ->where('discounted_price', '>', 0)
            ->limit(12)->get();

        $productsList = ProductListItemResource::collection($products);

        return $this->success($productsList);
    }

    public function show(Product $product)
    {

        $productData = new ProductResource($product);

        return $this->success($productData);
    }

    public function relatedProducts(Product $product)
    {
        $products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        $productsList = ProductListItemResource::collection($products);

        return $this->success($productsList);
    }

    public function store(StoreProductRequest $request)
    {

        try {

            DB::transaction(function () use ($request) {
                $request->createProduct();
            });

            return $this->success(null, 'Product created successfully', StatusCode::Continue->value);
        } catch (Exception $e) {
            return $this->failed(null, StatusCode::InternalServerError->value, $e->getMessage());
        }
    }


    public function update(Product $product, UpdateProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->updateProduct();
            });

            return $this->success(null, 'Product updated successfully', StatusCode::Continue->value);
        } catch (Exception $e) {
            return $this->failed(null, StatusCode::InternalServerError->value, $e->getMessage());
        }
    }

    public function reviews(Product $product)
    {
        $reviews = $product->reviews()
            ->latest()
            ->paginate(4);

        $reviewsList = ReviewResource::collection($reviews);

        $data = $this->paginatedData($reviews, $reviewsList);
        return $this->success([
            'paginated' => $data,
            'avg_rating' => $product->reviews()->avg('rating')
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->success(null, 'Product deleted successfully', StatusCode::Continue->value);
    }

    public function removeAdditionalImage(Product $product, $index)
    {

        $images = explode(',', $product->additional_images);

        unset($images[$index]);

        $product->additional_images = implode(',', $images);

        $product->save();

        return $this->success(null, 'Image removed successfully', StatusCode::Continue->value);
    }

    private function getRatingDistribution(Product $product)
    {
        $totalReviews = $product->reviews()->count() > 1 ? $product->reviews()->count() : 1;


        $ratingsDistribution = [
            '5 stars' => [
                'count' => $product->reviews()->where('rating', 5)->count(),
                'percent' => number_format(($product->reviews()->where('rating', 5)->count() / $totalReviews) * 100, 2)
            ],

            '4 stars' => [
                'count' => $product->reviews()->where('rating', 4)->count(),
                'percent' => number_format(($product->reviews()->where('rating', 4)->count() / $totalReviews) * 100, 2)
            ],
            '3 stars' => [
                'count' => $product->reviews()->where('rating', 3)->count(),
                'percent' => number_format(($product->reviews()->where('rating', 3)->count() / $totalReviews) * 100, 2)
            ],
            '2 stars' => [
                'count' => $product->reviews()->where('rating', 2)->count(),
                'percent' => number_format(($product->reviews()->where('rating', 2)->count() / $totalReviews) * 100, 2)
            ],
            '1 star' => [
                'count' => $product->reviews()->where('rating', 1)->count(),
                'percent' => number_format(($product->reviews()->where('rating', 1)->count() / $totalReviews) * 100, 2)
            ]
        ];


        return $ratingsDistribution;
    }
}
