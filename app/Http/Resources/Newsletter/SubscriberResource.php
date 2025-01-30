<?php

namespace App\Http\Resources\Newsletter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
