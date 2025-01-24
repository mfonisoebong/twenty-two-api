<?php

namespace App\Http\Controllers\Invoice;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\Invoice\InvoiceItemResource;
use App\Http\Resources\InvoiceTransactionResource;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Notifications\Invoice\InvoiceAction;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use HttpResponses, Pagination;

    public function viewOrders(Request $request)
    {

        $invoiceItems = InvoiceItem::where(function ($query) use ($request) {

             $status = $request->get('status');

           
                $query->whereHas('invoice', function ($query) use ($request, $status) {              

                    if($status){
                        $query
                        ->where('status', '=', $status);
                    }

                    $query
                    ->where('user_id', $request->user()->id);
                });

        })->paginate(12);

        $invoiceItemsList = InvoiceItemResource::collection($invoiceItems);

        $data = $this->paginatedData($invoiceItems, $invoiceItemsList);

        return $this->success($data);

    }

    public function viewOrder(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $data = [
            'id' => (string)$invoice->id,
            'items_count' => $invoice->items()->count(),
            'created_at' => $invoice->created_at->format('Y-m-d'),
            'amount_paid' => currency_format($invoice->amount_paid),
            'status' => $invoice->status,
            'items' => InvoiceItemResource::collection($invoice->items),
            'payment_method' => [
                'method' => 'Payment gateway',
                'total' => currency_format($invoice->amount_paid),
                'sub_total' => currency_format($invoice->sub_total),
                'shipping_fee' => currency_format($invoice->shipping_fee),
                'coupon' => $invoice->coupon?->code,
            ],
            'billing' => [
                'delivery_type' => 'Door delivery',
                'information' => json_decode($invoice->billing_information)
            ]
        ];

        return $this->success($data);
    }

    public function viewOrderHistory(Request $request)
    {

        $invoiceItems = InvoiceItem::where(function ($query) use ($request) {
            $query->whereHas('invoice', function ($query) use ($request) {
                $query
                    ->where('user_id', $request->user()->id);
            });
        })->paginate(12);

        $invoiceItemsList = InvoiceItemResource::collection($invoiceItems);

        $data = $this->paginatedData($invoiceItems, $invoiceItemsList);

        return $this->success($data);

    }

    public function deliveryStatus(Invoice $invoice)
    {

        $data = [
            'id' => (string)$invoice->id,
            'status' => $invoice->status,
        ];

        return $this->success($data);
    }

    public function viewAllOrders(Request $request)
    {
        $this->authorize('viewAny', Invoice::class);
       

        $invoices = Invoice::filter()
            ->paginate(15);
        $invoicesList = InvoiceTransactionResource::collection($invoices);

        $data = $this->paginatedData($invoices, $invoicesList);

        return $this->success($data);


    }

    public function viewInvoice(Invoice $invoice, Request $request)
    {
        $this->authorize('view', $invoice);

        $data = [
            'id' => (string)$invoice->id,
            'items' => InvoiceItemResource::collection($invoice->items),
            'status' => $invoice->status,
            'customer' => [
                'name' => $invoice->user->full_name,
                'email' => $invoice->user->email,
                'phone' => $invoice->user->phone,
            ],
            'billing_information' => json_decode($invoice->billing_information),
            'trx_id' => $invoice->trx_id,
            'payment_information' => [
                'coupon' => $invoice->coupon?->code,
                'shipping_fee' => currency_format($invoice->shipping_fee),
                'method' => 'Payment gateway',
                'total' => currency_format($invoice->amount_paid),
                'sub_total' => currency_format($invoice->sub_total),
            ]
        ];

        return $this->success($data);

    }

    public function update(Invoice $invoice, UpdateInvoiceRequest $request)
    {
        $this->authorize('update', $invoice);

        try {
            DB::transaction(function () use ($invoice, $request) {

                $request->updateStatus();

                $invoice->user->notify(new InvoiceAction($invoice));
            });
            return $this->success(null, 'Invoice updated successfully');
        } catch (\Exception $e) {
            return $this->failed(null, StatusCode::InternalServerError->value, $e->getMessage());
        }


    }
}
