<x-app-layout page-title="All Tagss">
    <section class="p-6">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="fw-600 h4">All Tags</h1>
                </div>
                <div class="col-lg-12">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="/">Blog</a>
                            
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="/blog/tag/all">"All Tags"</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white pb-4">
        <div class="container">
            <div class="col-xl-11 mx-auto">
                @foreach ($tags as $tag)
                <a href="/blog/category/{{ $tag->slug }}">{{ $tag->tag_name }}</a>
                <br><br>
                @endforeach
            </div>
        </div>
    </section>     
</x-app-layout>
