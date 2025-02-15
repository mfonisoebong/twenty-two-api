<?php

namespace App\Http\Resources\Invoice;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
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
            'product' =>  $this->product ? [
                'id' => (string)$this->product->id,
                'name' => $this->product->name,
                'featured_image' => $this->getFilePath($this->product->featured_image),
            ]: null,
            'invoice_id' => (string)$this->invoice_id,
            'status' => $this->invoice->status,
            'created_at' => $this->created_at->format('Y-m-d'),
            'quantity' => $this->quantity,
            'unit_price' => currency_format($this->unit_price),
            'total' => currency_format($this->total),
        ];
    }
}
