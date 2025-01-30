<?php

namespace App\Http\Requests\Home;

use App\Models\HeroDetails;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Http\FormRequest;

class StoreHeroDetailsRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:3072'],
            'button_text' => ['required', 'string'],
            'button_link' => ['required', 'string'],
            'image_sm' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:3072'],
        ];
    }

    public function createDetails()
    {
        $image = $this->uploadFile($this->file('image'), 'hero_details');
        $imageSm = $this->uploadFile($this->file('image_sm'), 'hero_details');
        $data = [
            ...$this->except(['image', 'image_sm']),
            'image_sm' => $imageSm,
            'image' => $image,
        ];
        HeroDetails::create($data);
    }
}
