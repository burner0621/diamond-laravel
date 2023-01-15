<x-app-layout page-title="{{ $post->meta_title?$post->meta_title:$post->name }}" page-description="{{$post->meta_description}}">
    <section class="bg-white py-8">
        <div class="container">
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="blog-post-single-container">
                        <div class="border-bottom mb-2">
                            <h1 class="text-black fw-700 article-single-title">{{ $post->name }}</h1>
                            <div class="mb-2 opacity-50 article-single-category">
                                <i>
                                    Published in 
                                    @foreach($post->categories as $category_info)
                                    <a href="#" >{{$category_info->category->category_name}}</a>, 
                                    @endforeach
                            
                                </i>
                            </div>
                        </div>
                        <div class="mb-4 article-single-post overflow-hidden">
                            {!! $post->post !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
