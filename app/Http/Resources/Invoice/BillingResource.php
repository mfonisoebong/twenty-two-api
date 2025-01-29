<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'country' => $this->country,
            'state' => $this->state,
            'apartment' => $this->apartment,
            'city' => $this->city,
            'phone' => $this->phone,
            'email' => $this->email,
            'user_id' => (string)$this->user_id,
            'is_default' => (bool)$this->is_default
        ];
    }
}
