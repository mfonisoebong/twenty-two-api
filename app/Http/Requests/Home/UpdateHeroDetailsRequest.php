<?php

namespace App\Http\Requests\Home;

use App\Traits\UploadFiles;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroDetailsRequest extends FormRequest
{
    use UploadFiles;

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
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:3072'],
            'image_sm' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:3072'],
            'button_text' => ['required', 'string'],
            'button_link' => ['required', 'string'],
        ];
    }

    public function updateDetails()
    {
        $details = $this->route('details');

        $image = $this->file('image') ?
            $this->uploadFile($this->file('image'), 'hero_details') :
            $details->image;
        $imageSm = $this->file('image_sm') ?
            $this->uploadFile($this->file('image_sm'), 'hero_details') :
            $details->image_sm;

        $data = [
            ...$this->except(['image', 'image_sm']),
            'image' => $image,
            'image_sm' => $imageSm,
        ];

        $details->update($data);
    }
}
