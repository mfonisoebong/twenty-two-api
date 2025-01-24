<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceTransactionResource extends JsonResource
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
            'status' => $this->status,
            'name' => $this->user->full_name,
            'email' => $this->user->email,
            'amount_paid' => currency_format($this->amount_paid),
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
