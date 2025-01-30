<?php

namespace App\Http\Resources\Home;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroDetailsResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->getFilePath($this->image),
            'image_sm' => $this->image_sm ? $this->getFilePath($this->image_sm) : null,
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
        ];
    }
}
