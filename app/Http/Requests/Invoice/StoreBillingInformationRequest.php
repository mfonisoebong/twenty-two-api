<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillingInformationRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'company_name' => ['nullable', 'string'],
            'apartment' => ['required', 'string'],
            'city' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            'is_default' => ['required', 'boolean'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
        ];
    }

    public function createBillingInfo()
    {
        $user = $this->user();

        if ($this->is_default) {
            $user->billingInformations()
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }
        $info = $user->billingInformations()->create($this->validated());

        return $info;
    }
}
