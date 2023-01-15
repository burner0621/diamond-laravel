<x-app-layout page-title="Searching for {{request()->q ?? request()->category}}">
    <section class="product_detail_single py-9">
        <div class="container">
            <div class="search-page-title border-bottom mb-4 pb-2">
                <h1 class="text-black fw-700">Searching for {{request()->q ?? request()->category}}</h1>
            </div>
            <x-products-display :products="$products"/>
        </div>
    </section>
</x-app-layout>
