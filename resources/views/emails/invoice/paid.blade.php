@extends('layouts.emails.user')

@section('head')
    <style>

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .invoice-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .invoice-table td {
            text-align: right;
        }

        .invoice-table td.description {
            text-align: left;
        }

        .invoice-total {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div>
        <p>
            Hi {{$invoice->user->name}},
        </p>
        <p>
            Thank you for your order to {{config('app.name')}}! We've received your payment for your order
            # {{$invoice->id}}
            and it's now being processed.
        </p>
        <p>
            Here's a quick recap of your order:
            <br>
            <b>Order Number: </b> {{$invoice->id}}
            <br>
            <b>Order Date: </b> {{$invoice->created_at->format('d-M-Y')}}

        </p>

        <p>Items Ordered:</p>
    </div>

    <x-emails.invoice-table :invoice="$invoice"/>

    <div>
        <p>What's Next?</p>
        <p>
            We'll keep you updated on the status of your order. You can expect to receive a separate email with tracking
            information once your order has shipped.
        </p>
        <p>In the meantime, you can:
            <br>

            View your order details by logging into your {{config('app.name')}} account.
            Track your order's progress once it ships (tracking information will be emailed to you).
        </p>
    </div>

    <div>
        <p>Need Help?</p>
        <p>
            If you have any questions about your order, please don't hesitate to contact our customer support team at
            <a href="mailto:support@ttavenue.com">support@ttavenue.com</a>.
        </p>
        <p>
            We appreciate your business and look forward to getting your order to you soon!
        </p>
    </div>

@endsection
