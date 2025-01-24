<?php

namespace App\Http\Requests\Coupon;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code' => ['required', 'string', 'unique:coupons,code'],
            'start_date' => ['required', 'string'],
            'end_date' => ['required', 'string', 'after:start_date'],
            'type' => ['required', 'in:percent,fixed'],
            'value' => ['required', 'numeric'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function createCoupon()
    {
        Coupon::create($this->validated());
    }
}
