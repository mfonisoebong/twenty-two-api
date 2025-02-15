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
        'shipping_details',
        'colors',
        'sizes',
        'available_units',
        'category_id',
        'colors_list',
        'units_sold'
    ];

    public function scopeFilter(Builder $builder)
    {

        $builder->when(request('search'), function ($builder) {
            $builder->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');
        });
        $builder->when(request('size'), function ($builder) {
            $builder->where('sizes', 'like', '%' . request('size') . '%');
        });
        $builder->when(request('color'), function ($builder) {
            $builder->where('colors_list', 'like', '%' . request('color') . '%');
        });
        $builder->when(request('price_start'), function ($builder) {
            $builder->where('base_price', '>=', request('price_start'));
        });

        $builder->when(request('price_end'), function ($builder) {
            $builder->where('base_price', '<=', request('price_end'));
        });

        $builder->when(request('sort_by'), function ($builder) {
            if (request('sort_by') === 'newest') {
                $builder->latest();
            }
            if (request('sort_by') === 'best_selling') {
                $builder->orderBy('units_sold', 'desc');
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getPriceAttribute()
    {
        return (float)$this->discounted_price ? (float)$this->discounted_price : $this->base_price;
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
