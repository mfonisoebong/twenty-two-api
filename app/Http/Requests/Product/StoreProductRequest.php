<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'featured_image' => ['required', 'image', 'max:3072', 'mimes:jpeg,jpg,png'],
            'additional_images' => ['nullable', 'array', 'max:3'],
            'additional_images.*' => ['image', 'max:3072', 'mimes:jpeg,jpg,png'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:5000'],
            'shipping_details' => ['nullable', 'string', 'max:5000'],
            'colors' => ['required', 'array'],
            'colors.*.name' => ['string', 'max:255'],
            'colors.*.color' => ['string', 'max:255'],
            'sizes' => ['required', 'array'],
            'sizes.*' => ['string', 'max:255'],
            'available_units' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function createProduct()
    {


        $featuredImage = $this->uploadFile($this->file('featured_image'), 'products');
        $additionalImages = $this->file('additional_images') && count($this->file('additional_images')) > 0 ?
            $this->uploadFiles($this->file('additional_images'), 'products') :
            [];
        $colors = json_encode($this->input('colors'));
        $colorsList = implode(',', array_column($this->input('colors'), 'name'));
        $sizes = implode(',', $this->input('sizes'));


        Product::create([
            ...$this->except(['featured_image', 'additional_images', 'colors', 'sizes']),
            'featured_image' => $featuredImage,
            'additional_images' => implode(',', $additionalImages),
            'colors' => $colors,
            'sizes' => $sizes,
            'colors_list' => $colorsList,
        ]);
    }
}
