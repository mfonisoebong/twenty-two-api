<?php

namespace App\Http\Resources\Invoice;

use App\Traits\Currency;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    use Currency;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'status' => Invoice::STATUS_MAP[$this->status],
            'name' => $this->user->name,
            'email' => $this->user->email,
            'amount_paid' => $this->formatAmount($this->amount_paid),
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
