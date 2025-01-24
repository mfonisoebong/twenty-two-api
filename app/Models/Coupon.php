<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'type',
        'value',
        'status'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getValueCalculatedAttribute()
    {

        if ($this->type === 'percent') {
            return (float)$this->value / 100;
        }
        return (float)$this->value;
    }

    public function getExpiredAttribute()
    {
        $endDate = Carbon::parse($this->end_date);
        $startDate = Carbon::parse($this->start_date);
        return $endDate->lt(Carbon::now()) || $startDate->gt(Carbon::now());
    }

    public function calculateDeducted($amount)
    {
        $value = $this->getValueCalculatedAttribute();
        $deduction = $this->type === 'percent' ? $value * (float)$amount
            : $value;
        return (float)$amount - $deduction;
    }
}
