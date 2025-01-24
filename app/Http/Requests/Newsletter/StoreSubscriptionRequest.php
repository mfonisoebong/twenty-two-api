<?php

namespace App\Http\Requests\Newsletter;

use App\Models\NewsletterSubscription;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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
            'email'=> ['required', 'email', 'unique:newsletter_subscriptions,email'],
        ];
    }

    public function addSubscription()
    {
        NewsletterSubscription::create($this->validated());

    }
}
