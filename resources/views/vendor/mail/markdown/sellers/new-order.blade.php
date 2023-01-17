@component('mail::message')
    <style>
        table {
            width: 100% !important;
            text-align: center;
        }
        .order-detail{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .order-detail th, .order-detail td{
            border: 1px solid black;
            padding: 0px 6px;
        }
    </style>
    <div>
        <p><span>Dear {{$order->store->user->name}},</span></p>
        <p><span>A customer has placed an order for your product(s).</span></p>
        <p></p>
        <p><span>Invoice #&nbsp;</span><strong><span>{{$order->id}}</span></strong></p>
        <table class="order-detail" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
                <td>
                    <p><span>Reference</span></p>
                </td>
                <td>
                    <p><span>Product Name</span></p>
                </td>
                <td>
                    <p><span>Quantity</span></p>
                </td>
                <td>
                    <p><span>Price</span></p>
                </td>
                <td>
                    <p><span>Total</span></p>
                </td>

            </tr>
            @foreach($order->products as $product)
            <tr>
                <td>
                    <p><strong><span>Product Reference #</span></strong></p>
                </td>
                <td>
                    <p><strong><span>{{$product->name}}</span></strong></p>
                </td>
                <td>
                    <p><strong><span>{{$product->pivot->quantity}}</span></strong></p>
                </td>
                <td>
                    <p><strong><span>{{ceil($product->pivot->subtotal/$product->pivot->quantity)}}</span></strong></p>
                </td>
                <td>
                    <p><strong><span>{{$product->pivot->subtotal}}</span></strong></p>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>
        <p></p>
        <p><span>If you are unable to fulfil this order, please cancel the order immediately <a href="{{route('seller.order.index')}}"><strong>here</strong></a>. The order will be automatically cancelled do not accept the order within 3 working days.</span></p>
        <p><span>&nbsp;</span></p>
        <p><span>
                Otherwise, to accept the order, please <a href="{{route('seller.order.index')}}"><strong>click here.</strong></a>
            </span></p>
        <p></p>
        <p><span>If you have any questions, contact us at (</span><a href="mailto:admin@shukshuk.com"><strong><u><span>{{trans('email.email-contact')}}</span></u></strong></a><strong><span>)</span></strong></p>
        <p></p>
        <p><span>Click this <strong><a href="{{route('home')}}">link&nbsp;</a></strong>to return to our website.</span></p>
        <p></p>
        <p><span>Thanks for being a part of our family!</span></p>
        <p><span>Loads of love,</span></p>
        <p><span>{{trans('email.regard')}}</span></p>
        <p><br></p>

@endcomponent
