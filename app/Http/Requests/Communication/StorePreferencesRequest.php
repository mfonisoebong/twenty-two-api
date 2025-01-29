<?php

namespace App\Http\Requests\Communication;

use Illuminate\Foundation\Http\FormRequest;

class StorePreferencesRequest extends FormRequest
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
            'preferences' => ['array'],
            'preferences.*' => ['string', 'in:all,sales,new_arrivals,special_edition,discounts,collection'],
        ];
    }

    public function savePreferences()
    {
        $user = $this->user();
        if (array_search('all', $this->preferences)) {
            $user->communication_preference = 'all';
            $user->save();
            return;
        }

        $preferences = implode(',', $this->preferences);
        $user->communication_preference = $preferences;
        $user->save();
    }
}
