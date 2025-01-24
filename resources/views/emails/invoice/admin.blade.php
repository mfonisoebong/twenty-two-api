@extends('layouts.emails.admin')

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

        <p>Hi Admin Team,</p>
        <p>
            This is an automated notification to inform you that a new invoice has been created for order
            # {{$invoice->id}}
            .
        </p>
        <p>
            Order Details:
        </p>
        <p>
            Customer Name: {{$invoice->user->name}}
        </p>
        <p>
            Order Date: {{$invoice->created_at->format('d-m-Y')}}
        </p>
        <p>
            Order Total: NGN {{$invoice->amount_paid}}
        </p>
    </div>

    <div>
        <x-emails.invoice-table :invoice="$invoice"/>

        <p>
            Payment Status: <span style="text-transform: capitalize">{{$invoice->status}}</span>
        </p>
        <p>
            @php
                $link= config('app.admin_url').'/sales/'.$invoice->id;
            @endphp
            Link to Order: <a href="{{$link}}" target="_blank">{{$link}}</a>
        </p>
    </div>

@endsection
