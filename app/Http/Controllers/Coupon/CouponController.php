<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use HttpResponses;

    public function viewAll()
    {
        $coupons = Coupon::paginate(12);

        return $this->success($coupons);
    }

    public function view(Coupon $coupon)
    {
        return $this->success($coupon);
    }

    public function store(StoreCouponRequest $request)
    {
        $request->createCoupon();
        return $this->success(null, 'Coupon created successfully');
    }

    public function update(Coupon $coupon, UpdateCouponRequest $request)
    {
        $request->updateCoupon();
        return $this->success(null, 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return $this->success(null, 'Coupon deleted successfully');
    }

}
