<?php

namespace App\Http\Requests\Notification;

use App\Models\User;
use App\Notifications\Admin\AdminNotification;
use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'message' => ['required', 'string'],
            'users' => ['required', 'array'],
            'users.*' => ['required', 'integer', 'exists:users,id'],
            'all_users' => ['required', 'boolean'],
        ];
    }

    public function sendNotifications()
    {

        if ($this->all_users) {
            $users = User::all();

            $users->each(function ($user) {
                $user->notify(new AdminNotification($this->title, $this->message));
            });
        } else {
            $users = User::whereIn('id', $this->users)->get();
            $users->each(function ($user) {
                $user->notify(new AdminNotification($this->title, $this->message));
            });
        }
    }
}
