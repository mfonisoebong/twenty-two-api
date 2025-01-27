<?php

namespace App\Http\Resources\Category;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'slug' => $this->slug,
            'featured_image' => $this->getFilePath($this->featured_image),
            'is_featured' => (bool)$this->is_featured,
            'description' => $this->description,
        ];
    }
}
