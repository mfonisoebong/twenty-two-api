<?php

namespace App\Http\Resources\Invoice;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentPurchaseResource extends JsonResource
{
    use UploadFiles;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $amount = $this->unit_price * $this->quantity;
        return [
            'id' => (string)$this->id,
            'product' => $this->name ? [
                'name' => $this->name,
                'featured_image' => $this->getFilePath($this->featured_image),
            ] : null,
            'amount' => currency_format($amount),
            'trx_id' => $this->trx_id,
        ];
    }
}
