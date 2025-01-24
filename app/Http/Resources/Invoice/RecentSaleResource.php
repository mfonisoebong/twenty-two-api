<?php

namespace App\Http\Resources\Invoice;

use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentSaleResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'avatar' => $this->getFilePath($this->user->avatar),
            'amount' => currency_format($this->amount_paid),
        ];
    }
}
