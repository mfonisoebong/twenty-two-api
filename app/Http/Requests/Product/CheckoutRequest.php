<?php

namespace App\Http\Requests\Product;

use App\Models\Coupon;
use App\Models\ShippingFee;
use App\Traits\Cart;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class CheckoutRequest extends FormRequest
{
    use Cart;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'company_name' => ['nullable', 'string'],
            'apartment' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            'save_billing' => ['required', 'boolean'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
        ];
    }


    public function validateProducts()
    {
        $items = auth()->user()->cartItems;

        $validProducts = [];

        if (empty($items)) {
            throw new Exception('You have no items in your cart');
        }

        foreach ($items as $item) {


            if ($item->product->available_units < $item->quantity) {
                throw new Exception('Product is out of stock');
            }
            $productArr = $item->product->toArray();
            $productArr['quantity'] = $item['quantity'];
            $productArr['price'] = $item->product->price;
            $productArr['color'] = $item->color;
            $productArr['size'] = $item->size;
            array_push($validProducts, $productArr);
        }

        $couponCode = $this->input('coupon_code');

        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon && $coupon->expired) {
            throw new Exception('Coupon is invalid');
        }

        return $validProducts;
    }


    public function saveBillingInformation()
    {
        if (!$this->input('save_billing')) {
            return;
        }
        $user = $this->user();
        $billingInformation = $this->except('save_billing', 'coupon_code');
        // Create or update
        $user->billingInformations()->create($billingInformation);
    }

    public function calculatePrice(array $products)
    {
        $amounts = array_map(function ($item) {
            return (float)$item['price'] * $item['quantity'];
        }, $products);
        $coupon = Coupon::where('code', $this->input('coupon_code'))
            ->where('status', 'active')
            ->first();

        $totalAmount = array_sum($amounts);
        $shipping = ShippingFee::first()?->fee ?? 0;
        $amountToPay = $totalAmount + (float)$shipping;
        $deductedAmount = $coupon ? $coupon->calculateDeducted($amountToPay) : $amountToPay;

        return $deductedAmount;
    }

    public function generateInvoice($amount, $items)
    {


        $coupon = Coupon::where('code', $this->input('coupon_code'))
            ->where('status', 'active')
            ->first();
        $user = $this->user();
        $billingInformation = json_encode($this->except('save_billing', 'coupon_code'));
        $shipping = ShippingFee::first()?->fee ?? 0;

        $trxId = Str::uuid();
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'billing_information' => $billingInformation,
            'amount_paid' => $amount,
            'coupon_id' => $coupon?->id,
            'shipping_fee' => $shipping,
            'trx_id' => $trxId,
            'status' => 'pending'
        ]);

        foreach ($items as $item) {
            $invoice->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'color' => $item['color'],
                'size' => $item['size']
            ]);
        }
        return $invoice;
    }

    public function generatePaymentLink(Invoice $invoice)
    {
        $amount = $invoice->amount_paid;

        $headers = [
            'Authorization' => 'Bearer ' . config('services.paystack.secret_key')
        ];
        $postUrl = config('services.paystack.url') . '/transaction/initialize';
        $email = $this->input('email');
        $postData = [
            'email' => $email,
            'amount' => (string)($amount * 100),
            'reference' => $invoice->trx_id,
            'callback_url' => config('services.paystack.callback_url'),
        ];

        $response = Http::withHeaders($headers)
            ->post($postUrl, $postData);
        if (!$response->successful()) {
            throw new \Exception($response->json()['message']);
        }

        $paymentUrl = $response->json()['data']['authorization_url'];


        $invoice->update(['payment_url' => $paymentUrl]);

        return $paymentUrl;
    }
}
