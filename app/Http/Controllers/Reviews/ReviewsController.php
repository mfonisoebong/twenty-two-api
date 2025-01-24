<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\Review\ReviewItemResource;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    use HttpResponses, Pagination, UploadFiles;


    public function viewProductReviews(Product $product)
    {
        $reviews = $product->reviews()
            ->latest()
            ->paginate(12);

        $reviewsList = ReviewResource::collection($reviews);

        $data = $this->paginatedData($reviews, $reviewsList);
        return $this->success($data);
    }

    public function store(StoreReviewRequest $request)
    {
        $request->addReview();

        return $this->success(null, 'Review added successfully');
    }

    public function viewAll()
    {
        $reviews = Review::paginate(12);

        $reviewsList = ReviewItemResource::collection($reviews);

        $data = $this->paginatedData($reviews, $reviewsList);

        return $this->success($data);
    }

    public function view(Review $review)
    {
        $data = [
            'id' => (string)$review->id,
            'review' => $review->review,
            'rating' => $review->rating,
            'product' => [
                'id' => (string)$review->product->id,
                'name' => $review->product->name,
                'featured_image' => $this->getFilePath($review->product->featured_image),
                'description' => $review->product->description,
                'price' => $review->product->price,
            ],
            'user' => [
                'name' => $review->user->full_name,
                'email' => $review->user->email,
                'phone' => $review->user->phone,
                'id' => (string)$review->user->id,
            ],
            'headline' => $review->headline,
            'nickname' => $review->nickname,
            'location' => $review->location,
            'width' => $review->width,
            'fit_report' => $review->fit_report,
            'comfort' => $review->comfort,
            'durability' => $review->durability,
            'bottom_line' => $review->bottom_line,
            'image' => $this->getFilePath($review->image),
            'video' => $this->getFilePath($review->video),
            'created_at' => $review->created_at->format('Y-m-d')
        ];

        return $this->success($data);
    }


}
