<?php

namespace App\Http\Requests\Invoice;

use App\Models\BillingInformation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBillingInformationRequest extends FormRequest
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

    public function updateInfo()
    {
        $user = $this->user();
        $info = $this->route('info');

        if ($this->is_default) {
            $user->billingInformations()->update(['is_default' => false]);
        }

        $info->update($this->validated());

        return $info;
    }
}
