<x-app-layout page-class="track-order" page-title="Track Order" page-description="">
    <section class="product_detail_single py-6">
        <div class="container py-7">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="card col-md-4">
                            <div class="card-body">
                                @include('includes.validation-form')

                                <form method="GET" action="{{ route('track.order') }}">
                                    @csrf
                                    <div class="col-md-12 mb-2">
                                        <label for="name">Order ID:</label>
                                        <input type="text" name="orderId" class="form-control" required>
                                    </div>

                                    <!-- Email Address -->
                                    <div class="col-md-12 mb-5">
                                        <label for="email">Email address:</label>
                                        <input type="text" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-outline-success">Track Order</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section>
</x-app-layout>
