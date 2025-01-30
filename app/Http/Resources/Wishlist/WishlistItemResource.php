<?php

namespace App\Http\Resources\Wishlist;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
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
                'id' => (string)$this->product->id,
                'name' => $this->product->name,
                'featured_image' => $this->getFilePath($this->product->featured_image),
                'discounted_price' => $this->product->discounted_price ?  currency_format($this->product->discounted_price) : null,
                'base_price' => currency_format($this->product->base_price),
            ]
        ];
    }
}
