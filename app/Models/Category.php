<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HttpResponses;
use App\Http\Requests\Category\StoreCategoryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HttpResponses;

    protected $fillable = [
        'name',
        'slug',
        'featured_image',
        'is_featured',
        'description'
    ];

    public function scopeFilter(Builder $builder)
    {
        $builder->when(request('is_featured') === 'true', function ($builder) {
            $builder->where('is_featured', true);
        });

        $builder->when(request('is_featured') === 'false', function ($builder) {
            $builder->where('is_featured', false);
        });

        $builder->when(request('search'), function ($builder) {
            $builder->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('slug', 'like', '%' . request('search') . '%');
        });
    }

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
