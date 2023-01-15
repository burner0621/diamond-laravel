<x-app-layout page-title="My Orders">
<div class="container">
    <div class="col-lg-8 col-md-10 pt-9 pb-8 mx-auto checkout-wrap">
        <h1 class="fw-800">Order history</h1>
        <p class="pb-4">Check the status of recent orders, view order details, and fufilment status.</p>
        
        <ul class="nav nav-pills mb-5">
            <li class="nav-item">
                <a class="nav-link {{ \Route::currentRouteName() == 'orders.index' ? 'active' :'' }}" href="{{ route('orders.index') }}">Product Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ \Route::currentRouteName() == 'services.orders' ? 'active' :'' }}" href="{{ route('services.orders') }}">Service Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ \Route::currentRouteName() == 'courses.orders' ? 'active' :'' }}" href="{{ route('courses.orders') }}">Course Orders</a>
            </li>
        </ul>

        <x-orders-table :orders="$orders"/>
        {{$orders->links()}}

    </div>
</div>
</x-app-layout>
