<div class="mb-2">
    Address:
    <span class="text-secondary">{{$order->billing_address1}}</span>
</div>
<div class="mb-2">
    Secondary Address:
    <span class="text-secondary">{{$order->billing_address2}}</span>
</div>
<div class="mb-2">
    City:
    <span class="text-secondary">{{$order->billing_city}}</span>
</div>
<div class="mb-2">
    State:
    <span class="text-secondary">{{$order->billing_state}}</span>
</div>
<div class="mb-2">
    Country:
    <span class="text-secondary">{{$order->billing_country}}</span>
</div>
@if ($order->billing_phonenumber != '')
    <div class="mb-2">
        Phone:
        <span class="text-secondary">{{$order->billing_phonenumber}}</span>
    </div>
@endif

<form action="{{route('orders.update', $order)}}" method="post">
    @csrf
    @method('patch')
    <div class="mb-2">
        Status:
        <span class="link-primary">{{$order->status_payment == 1 ? 'Unpaid' : 'Paid'}}</span>
    </div>
    @if ($order->message)
        <div>
            Message:
            @if ($edit)
                <input type="text" value="{{old('message') ?? $order->message}}" placeholder="{{$order->message}}" name="message" id="message" class="form-control">
            @else
                <span class="link-secondary">{{$order->message}}</span>
            @endif
        </div>
    @endif
</form>
