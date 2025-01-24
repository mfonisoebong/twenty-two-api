<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateCredentialsRequest  extends FormRequest
{

    public bool $updatedEmail = false;

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
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user()->id)],
            'current_password' => ['nullable', 'string', 'min:8', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'max:255', 'confirmed']
        ];
    }


    public function updateCredentials()
    {

        $user = $this->user();

        if ($this->password && !Hash::check($this->current_password, $user->password)) {
            throw new \Exception('Current password is incorrect');
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        if ($this->email !== $user->email) {
            $user->email_verified_at = null;
            $this->updatedEmail = true;
        }
        $user->email = $this->email;
        $user->save();

        return $user;
    }
}
