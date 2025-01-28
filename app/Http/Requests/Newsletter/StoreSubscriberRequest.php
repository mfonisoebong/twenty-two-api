<?php

namespace App\Http\Requests\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
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
            'email' => ['email', 'unique:newsletter_subscribers,email', 'required_if:phone,null'],
            'phone' => ['string', 'max:255', 'required_if:email,null'],
            'dial_code' => ['string', 'max:255', 'required_with:phone'],
        ];
    }
}
