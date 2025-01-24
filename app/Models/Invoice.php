<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'billing_information',
        'amount_paid',
        'coupon_id',
        'trx_id',
        'shipping_fee',
        'payment_url'
    ];
    public const EVENTS = ['charge.success'];

    public const STATUS_MAP = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'in_transit' => 'In transit',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled'
    ];

    public function scopeFilter(Builder $builder)
    {
        $builder->when(request('status'), function ($builder) {
            $builder->where('status', request('status'));
        });

        $builder->when(request('search'), function ($builder) {
            $searchTerm = request('search');
            $builder->where('trx_id', $searchTerm)
                ->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->where('first_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getSubTotalAttribute()
    {
        $items = InvoiceItem::where('invoice_id', $this->id)
            ->get()
            ->toArray();

        $totalPrices = array_map(function ($item) {
            return (float)$item['unit_price'] * $item['quantity'];
        }, $items);

        return array_sum($totalPrices);
    }

//    public function getCouponAmountAttribute()
//    {
//        $parTotal = (float)$this->getSubTotalAttribute() + (float)$this->shipping_fee;
//
//        $couponAmount = $this->coupon ? $parTotal - $this->coupon?->calculateDeducted($parTotal) : 0;
//        return $couponAmount;
//    }
}
