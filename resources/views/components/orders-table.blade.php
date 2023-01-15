@foreach ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-6 mb-2">
                <div class="fw-600">Order number</div>
                <div>#{{$order->order_id}}</div>
            </div>
            <div class="col-lg-2 col-6 mb-2">
                <div class="fw-600">Date placed</div>
                <span>{{ date('F d, Y', strtotime($order->created_at)) }}</span>
            </div>
            <div class="col-lg-2 col-6 mb-2">
                <div class="fw-600">Items</div>
                <span>{{$order->items_count}}</span>
            </div>
            <div class="col-lg-2 col-6 mb-2">
                <div class="fw-600">Total amount</div>
                <span>${{$order->total_price}}</span>
            </div>
            <div class="col-lg-2 col-6 ml-auto">
                <a href="{{route('orders.show', $order->order_id)}}" class="btn btn-primary">View Order</a>
            </div>
        </div>
    </div>
</div>
@endforeach
