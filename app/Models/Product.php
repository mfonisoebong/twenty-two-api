<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'featured_image',
        'additional_images',
        'base_price',
        'discounted_price',
        'description',
        'additional_information',
        'colors',
        'sizes',
        'available_units',
        'category_id',
        'colors_list'
    ];

    public function scopeFilter(Builder $builder)
    {

        $builder->when(request('search'), function ($builder) {
            $builder->where('name', 'like', '%' . request('search') . '%');
        });
        $builder->when(request('size'), function ($builder) {
            $builder->where('sizes', 'like', '%' . request('size') . '%');
        });
        $builder->when(request('color'), function ($builder) {
            $builder->where('colors_list', 'like', '%' . request('color') . '%');
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceAttribute()
    {
        return $this->discounted_price ?? $this->base_price;
    }

    public function getFormattedPriceAttribute()
    {
        $price = $this->getPriceAttribute();

        return "£" . number_format($price, 2);
    }

    public function getInWishlistAttribute()
    {
        return auth()->check() && WishlistItem::where('product_id', $this->id)
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function getInCartAttribute()
    {
        return auth()->check() && CartItem::where('product_id', $this->id)
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function getCartItemAttribute()
    {
        return auth()->check() ? CartItem::where('product_id', $this->id)
            ->where('user_id', auth()->id())
            ->first() : null;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
