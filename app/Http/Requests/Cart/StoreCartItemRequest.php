<?php

namespace App\Http\Requests\Cart;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'color' => ['nullable', 'string'],
            'size' => ['nullable', 'string'],
        ];
    }

    public function addItem()
    {

        $user = $this->user();

        $product = Product::findOrFail($this->product_id);
        $color = json_decode($product->colors)[0];
        $colorData = $color->name;

        if ($user->cartItems()->where('product_id', $this->product_id)->exists()) {
            return;
        }

        $user->cartItems()->create([
            'product_id' => $this->product_id,
            'quantity' => $this->quantity ?? 1,
            'color' => $this->color ?? $colorData,
            'size' => $this->size ?? explode(',', $product->sizes)[0],
        ]);
    }
}
