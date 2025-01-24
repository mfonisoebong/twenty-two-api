<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingFee\SaveShippingFeeRequest;
use App\Models\ShippingFee;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ShippingFeeController extends Controller
{
    use HttpResponses;

    public function save(SaveShippingFeeRequest $request)
    {

        $request->saveShippingFee();

        return $this->success(null, 'Shipping fee saved successfully');
    }

    public function view()
    {
        $shippingFee = ShippingFee::first();

        return $this->success($shippingFee);
    }
}
