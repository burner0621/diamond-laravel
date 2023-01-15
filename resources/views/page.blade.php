<x-app-layout page-title="{{$page->meta_title?$page->meta_title:$page->name}}"  page-description="{{$page->meta_description}}">
    <div class="container">
        <div class="col-lg-8 col-md-10 py-8 mx-auto checkout-wrap">
            {!! $page->post !!}
        </div>
    </div>

    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
</x-app-layout>
