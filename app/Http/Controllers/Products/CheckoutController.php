<?php

namespace App\Http\Controllers\Products;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CheckoutRequest;
use App\Mail\Invoice\AdminNotificationMail;
use App\Models\Coupon;
use App\Models\ShippingFee;
use App\Models\User;
use App\Notifications\Invoice\InvoiceAction;
use App\Traits\Cart;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    use Cart, HttpResponses;


    public function checkout(CheckoutRequest $request)
    {

        $user = $request->user();
        try {
            $products = $request->validateProducts();

            $request->saveBillingInformation();

            DB::beginTransaction();

            $coupon = Coupon::where('code', '=', $request->coupon_code)
                ->first();

            $summary = $this->getOrderSummary($user->cartItems, $coupon);


            $invoice = $request->generateInvoice($summary['total'], $products);

            $paymentUrl = $request->generatePaymentLink($invoice);



            DB::commit();

            $user->notify(new InvoiceAction($invoice));
            Mail::to(config('app.admin_email'))->send(new AdminNotificationMail($invoice));
            $user->cartItems()->delete();

            return $this->success([
                'payment_url' => $paymentUrl,
            ], 'Checkout successful');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->failed(null, StatusCode::InternalServerError->value, 'An error occurred while processing your request');
        }
    }

    public function getCheckoutSummary(Request $request)
    {
        $cartItems = $request->user()->cartItems;
        $coupon = Coupon::where('code', '=', $request->coupon_code)
            ->first();
        $summary = $this->getOrderSummary($cartItems, $coupon);

        return $this->success($summary, 'Checkout summary retrieved successfully');
    }
}
