<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Http\Resources\Cart\CartItemResource;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Traits\Cart;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use HttpResponses, Cart, Pagination;

    public function viewAll(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->cartItems()->paginate(6);

        $cartItemsList = CartItemResource::collection($cartItems);

        $data = $this->paginatedData($cartItems, $cartItemsList);

        return $this->success($data);
    }

    public function store(StoreCartItemRequest $request)
    {
        $request->addItem();

        return $this->success(null, 'Product added to cart successfully');
    }

    public function destroy(CartItem $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return $this->success(null, 'Product removed from cart successfully');

    }

    public function update(CartItem $item, UpdateCartItemRequest $request)
    {
        $request->updateCartItem();

        $cartItems = $request->user()->cartItems;

        $orderSummary = $this->getOrderSummary($cartItems);
        return $this->success($orderSummary);
    }

    public function viewOrderSummary(Request $request)
    {
        $cartItems = $request->user()->cartItems;

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', '=', 'active')
            ->first();

        $orderSummary = $this->getOrderSummary($cartItems, $coupon);

        return $this->success($orderSummary);
    }


}
