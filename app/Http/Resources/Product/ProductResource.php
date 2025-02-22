<?php

namespace App\Http\Resources\Product;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    use UploadFiles;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = explode(',', $this->additional_images);

        $additionalImages = !$images[0] ? [] : array_map(fn($image) => $this->getFilePath($image), $images);


        return [
            'id' => (string)$this->id,
            'category' =>  [
                'id' => (string)$this->category?->id ?? '',
                'name' => $this->category?->name ?? '',
                'slug' => $this->category?->slug ?? '',
            ],
            'description' => $this->description,
            'featured_image' => $this->getFilePath($this->featured_image),
            'additional_images' => $additionalImages,
            'name' => $this->name,
            'is_new' => $this->created_at->diffInDays() < 7,
            'price' => currency_format($this->price),
            'discounted_price_formatted' => (float)$this->discounted_price ? currency_format($this->discounted_price) : null,
            'discounted_price' => (float)$this->discounted_price ? (float)$this->discounted_price : null,
            'base_price' => (float)$this->base_price,
            'base_price_formatted' => currency_format($this->base_price),
            'rating' => [
                'average' => $this->reviews->avg('rating') ?? 0,
                'count' => $this->reviews->count()
            ],
            'sizes' => explode(',', $this->sizes),
            'colors' => json_decode($this->colors),
            'shipping_details' => $this->shipping_details,
            'available_units' => $this->available_units,
        ];
    }
}
