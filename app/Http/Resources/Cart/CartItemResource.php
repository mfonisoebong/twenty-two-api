<?php

namespace App\Http\Resources\Cart;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    use UploadFiles;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'product' => [
                'id' => (string)$this?->product_id,
                'name' => $this->product?->name,
                'featured_image' => $this->getFilePath($this->product?->featured_image),
                'price' => currency_format($this->product?->price ?? 0),
            ],
            'color' => $this->color,
            'size' => $this->size,
            'quantity' => $this->quantity,
            'total' => currency_format((float)$this->product->price * (int)$this->quantity),
        ];
    }
}
