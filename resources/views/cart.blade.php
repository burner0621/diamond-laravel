<x-app-layout page-title="Cart">
<div class="container">
    <div class="col-lg-4 col-md-6 py-9 mx-auto cart-wrap">
        <div class="card">
            @if (session('message'))
                <h4 class="text-center text-danger mt-3">
                    {{session('message')}}
                </h4>
            @endif
            <div class="card-body">
                <x-products-table locale="cart"/>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
