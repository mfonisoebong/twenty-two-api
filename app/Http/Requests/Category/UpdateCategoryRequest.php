<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $this->route('category')->id],
            'is_featured' => ['required', 'in:true,false'],
            'featured_image' => ['nullable', 'image', 'max:3072', 'mimes:jpeg,jpg,png'],
        ];
    }

    public function updateCategory()
    {
        $category = $this->route('category');
        $featuredImage = $this->file('featured_image') ?
            $this->uploadFile($this->file('featured_image'), 'categories') :
            $category->featured_image;

        $category->update([
            ...$this->except(['featured_image', 'is_featured']),
            'is_featured' => $this->is_featured === 'true',
            'featured_image' => $featuredImage,
        ]);
    }
}
