@props(['invoice'])

<table class="invoice-table">
    <thead>
    <tr>
        <th>Product(s) Name</th>
        <th>Product(s) Price (NGN)</th>
        <th>Product(s) Color</th>
        <th>Product(s) Size</th>
        <th>Product(s) Quantity</th>
        <th>Total (NGN)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->items as $item)
        <tr>
            <td class="description">{{$item->product->name}}</td>
            <td>{{$item->unit_price}}</td>
            <td>{{$item->color}}</td>
            <td>{{$item->size}}</td>
            <td>{{$item->quantity}}</td>

            @php
                $total = (float)$item->unit_price * $item->quantity;
            @endphp

            <td>{{number_format($total, 2)}}</td>
        </tr>
    @endforeach


    </tbody>
</table>

<div>
    <p>
        <b>Subtotal: NGN {{number_format($invoice->sub_total, 2)}}</b>
    </p>
    <p>
        <b>Shipping fee: NGN {{number_format($invoice->shipping_fee, 2)}}</b>
    </p>
    <p>
        <b>Total: NGN {{number_format($invoice->amount_paid, 2)}}</b>
    </p>
</div>
