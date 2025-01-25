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
        <p>Hi {{$invoice->user->name}},</p>
        <p>
            This is a friendly reminder that you have items waiting for you in your {{config('app.name')}} cart!
        </p>
        <p>
            We've saved the following items for you:
        </p>
    </div>

    <x-emails.invoice-table :invoice="$invoice"/>
    <div>
        <h5>
            Important Note:
        </h5>
        <p>This is not a confirmed order and the items in your cart are not reserved until you complete the checkout
            process.
            <br>
            We look forward to processing your order soon!
        </p>
    </div>

@endsection
