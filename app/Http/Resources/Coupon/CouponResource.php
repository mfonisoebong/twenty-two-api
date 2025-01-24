<?php

namespace App\Http\Resources\Coupon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'start_date' => $this->start_date,
            'code' => $this->code,
            'end_date' => $this->end_date,
            'type' => $this->type,
            'value' => (float)$this->value,
            'status' => $this->status
        ];
    }
}
