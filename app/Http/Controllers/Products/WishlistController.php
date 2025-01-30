<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Wishlist\WishlistItemResource;
use App\Models\Product;
use App\Models\WishlistItem;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use HttpResponses, Pagination;


    public function store(Product $product, Request $request)
    {
        $user = $request->user();

        $exists = $user->wishlistItems()->where('product_id', $product->id)->exists();

        if ($exists) {
            return $this->success([
                'count' => $user->wishlistItems()->count()
            ], 'Product added to wishlist successfully');
        }

        $user->wishlistItems()->create([
            'product_id' => $product->id
        ]);


        return $this->success([
            'count' => $user->wishlistItems()->count()
        ], 'Product added to wishlist successfully');
    }

    public function destroy(WishlistItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return $this->success(null, 'Product removed from wishlist successfully');
    }

    public function viewAll(Request $request)
    {

        $wishlistItems = $request->user()->wishlistItems()->paginate(6);
        $wishlistItemsList = WishlistItemResource::collection($wishlistItems);

        $data = $this->paginatedData($wishlistItems, $wishlistItemsList);

        return $this->success($data);
    }
}
