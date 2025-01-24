<?php

namespace App\Http\Requests\Auth;

use App\Models\OneTimePassword;
use App\Notifications\Auth\PasswordReset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ResetPasswordRequest extends FormRequest
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
            'code' => ['required', 'exists:one_time_passwords,code'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed']
        ];
    }

    public function resetPassword()
    {
        $otp = OneTimePassword::where('code', $this->code)
            ->first();

        $newPassword = Hash::make($this->password);

        $otp->user->password = $newPassword;
        $otp->user->save();

        $otp->user->notify(new PasswordReset());

        $otp->delete();
    }
}
