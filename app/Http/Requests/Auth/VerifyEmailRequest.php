<?php

namespace App\Http\Requests\Auth;

use App\Mail\Auth\WelcomeMail;
use App\Models\OneTimePassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;

class VerifyEmailRequest extends FormRequest
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
            'code' => ['required', 'string']
        ];
    }

    public function verifyEmail()
    {
        $otp = OneTimePassword::where('code', $this->code)
            ->where('type', 'email')
            ->first();

        if (!$otp) {
            throw new \Exception('Invalid OTP', 422);
        }

        $otp->user->email_verified_at = now();
        $otp->user->save();

         Mail::to($otp->user->email)
             ->send(new WelcomeMail($otp->user));

        $otp->delete();
    }
}
