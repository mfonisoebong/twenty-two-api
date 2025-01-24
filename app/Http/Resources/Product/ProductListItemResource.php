<?php

namespace App\Http\Resources\Product;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListItemResource extends JsonResource
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
            'name' => $this->name,
            'featured_image' => $this->getFilePath($this->featured_image),
            'is_new' => $this->created_at->diffInDays() < 7,
            'price' => currency_format($this->price),
            'discounted_price' => (float)$this->discounted_price ? currency_format($this->discounted_price) : null,
            'base_price' => currency_format($this->base_price),
            'rating' => [
                'average' => $this->reviews->avg('rating') ?? 0,
                'count' => $this->reviews->count()
            ],

        ];
    }
}
