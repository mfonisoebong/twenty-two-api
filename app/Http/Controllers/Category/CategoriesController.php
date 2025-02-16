<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductListItemResource;
use App\Models\Category;
use App\Models\Product;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use Pagination, HttpResponses;

    public function viewProducts(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->filter()
            ->paginate(16);
        $productsList = ProductListItemResource::collection($products);

        $data = $this->paginatedData($products, $productsList);

        return $this->success($data);
    }


    public function viewAll()
    {
        $categories = Category::filter()->get();

        $list = CategoryResource::collection($categories);

        return $this->success($list);
    }

    public function viewFeatured()
    {
        $categories = Category::where('is_featured', true)
            ->whereNot('featured_image', null)
            ->latest()
            ->get();
        $list = CategoryResource::collection($categories);

        return $this->success($list);
    }

    public function view(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        return $this->success(new CategoryResource($category));
    }

    public function store(StoreCategoryRequest $request)
    {
        $request->createCategory();
        return $this->success(null, 'Category created successfully');
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $request->updateCategory();
        return $this->success(null, 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('pages.admin.categories.edit', compact('category'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->success(null, 'Category deleted successfully');
    }
}
