<?php

namespace App\Http\Requests\Review;

use App\Models\Review;
use App\Traits\UploadFiles;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:5000'],
            'nickname' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'bottom_line' => ['required', 'in:recommend,not_recommend,highly_recommend'],
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpeg,jpg,png'],
            'video' => ['nullable', 'file', 'max:20480', 'mimes:mp4,webm,ogg,flv,mov,avi,wmv'],
        ];
    }

    public function addReview()
    {
        $user = auth()->user();

        $image = $this->file('image') ? $this->uploadFile($this->file('image'), 'reviews') : null;
        $video = $this->file('video') ? $this->uploadFile($this->file('video'), 'reviews') : null;

        Review::create([
            ...$this->except(['image', 'video']),
            'user_id' => $user->id,
            'image' => $image,
            'video' => $video,
        ]);
    }
}
