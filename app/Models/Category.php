<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HttpResponses;
use App\Http\Requests\Category\StoreCategoryRequest;

class Category extends Model
{
    use HasFactory, HttpResponses;

    protected $fillable = [
        'name',
        'slug',
        'featured_image',
        'is_featured'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function store(StoreCategoryRequest $request)
    {
        $request->createCategory();

        return $this->success(null, 'Category created successfully');
    }
}
