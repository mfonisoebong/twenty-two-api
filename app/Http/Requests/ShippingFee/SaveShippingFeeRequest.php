<?php

namespace App\Http\Requests\ShippingFee;

use App\Models\ShippingFee;
use Illuminate\Foundation\Http\FormRequest;

class SaveShippingFeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fee' => ['required', 'numeric'],
        ];
    }

    public function saveShippingFee()
    {
        $shippingFee = ShippingFee::first();

        if ($shippingFee) {
            $shippingFee->update($this->validated());
            return;
        }

        ShippingFee::create($this->validated());
    }
}
