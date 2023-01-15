<x-app-layout page-title="Blog">
    <section class="pt-9 p-6">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="fw-600 h4">Blog</h1>
                </div>
                <div class="col-lg-12">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="/">Home</a>
                            
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="/blog">"Blog"</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white pb-4">
        <div class="container">
            <div class="col-xl-11 mx-auto">
                <div class="row gutters-10 row-cols-lg-3 row-cols-md-2 row-cols-1">
                    @foreach ($posts as $post)
                    <div class="col mb-3">
                        <div class="blog-post-list-container">
                            <a href="{{ route('blog.post.url', ['slug'=>$post->slug]) }}" class="text-reset d-block">
                                @if($post->uploads->file_name == 'none.png')
                                    <img src="{{ asset('assets/img/placeholder.jpg') }}" alt="{{ $post->name }}" class="img-blog-cropped rounded border lazyloaded">
                                @else
                                    <img src="{{$post->uploads->getImageOptimizedFullName(400)}}" alt="{{ $post->name }}" class="img-blog-cropped rounded border lazyloaded">
                                @endif
                            </a>
                            <div class="p-2 pt-3">
                                <h2 class="fs-18 fw-600 mb-2">
                                    <a href="{{ route('blog.post.url', ['slug'=>$post->slug]) }}" class="text-reset article-list-title">
                                        {{ $post->name }}
                                    </a>
                                </h2>
                                <div class="mb-2 opacity-50 article-list-category">
                                    <span>Author: {{ $post->postauthor->first_name . " " . $post->postauthor->last_name }} </span>
                                </div>
                                
                                    <div class="mb-2 opacity-50 article-list-category">
                                        Published in: 
                                        @foreach($post->categories as $key => $category_info)
                                            @if($key>0) , @endif<a href="/blog/{{ $category_info->category->slug }}" >{{$category_info->category->category_name}}</a>
                                        @endforeach
                                    </div>
                               
                                <p class="opacity-70 mb-4 article-list-excerpt">{{-- excerpt --}}</p>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
