<div>
    <section class="hero-home pt-9 pb-6">
        <div class="container">
            <div class="row">
                <div class="col-12 hero-content-container">
                    <div class="hero-categories filter-categories pb-4 d-none">
                        <ul class="category-container">
                            <li class="mb-3 category active" data-category="all"><a href="#">Explore</a></li>
                            @foreach (\App\Models\ProductsCategorie::all() as $category)
                                <li class="category" data-category="{{ $category->category_name }}"><a
                                        href="#">{{ $category->category_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 mx-auto hero-content-container">
                    <h4 class="fs-20 pb-4 mb-0">The world's preferred source for Jewelry CG content</h4>
                    <h1 class="font-weight-bold pb-4 mb-0">Explore our vast collections of 3D models</h1>
                    <div class="search-form ml-auto mr-auto py-2">
                        <form method="get" action="{{ route('search') }}">
                            <div class="search-col">
                                <input type="hidden" value="all" id="category_id" name="category">
                                <input name="q" type="search" placeholder="Search" aria-label="Search"
                                    id="search" class="search-control">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="py-6">
        <div class="container">
            <div class="filter-panel">
                <div class="d-flex justify-content-end mb-4">
                    <a class="btn btn-primary" role="button" data-bs-toggle="collapse" href="#filterPanel" aria-expanded="false" aria-controls="filterPanel">Filter</a>
                </div>
                <div class="collapse" id="filterPanel">
                    <div class="card mb-4">
                        <div class="card-body d-flex justify-content-between p-2">
                            <div class="col-md-3 p-3">
                                <label for="imageAttributeFilter" class="form-label fw-bold">CATEGORY</label>
                                <ul class="nav flex-column category-list">
                                    @foreach ( $categories as $category )
                                        <li class="nav-item category-item">
                                            @if (count($category->subcategory) == 0)
                                                <label class="custom-checkbox-container">{{ $category->category_name }}
                                                    <input type="checkbox" id="category-{{ $category->id }}" value="{{ $category->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                            @else
                                                <label class="custom-checkbox-container">{{ $category->category_name }}
                                                    <input type="checkbox" id="category-{{ $category->id }}" value="{{ $category->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                @include('components.subcategory-list',['subcategories' => $category->subcategory])
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                @include('products.js')
                            </div>
                            <div class="col-md-9 d-flex flex-wrap justify-content-between">
                                @foreach ($attrs as $attr)
                                    <div class="col-md-3 p-3">
                                        <label for="colorAttributeFilter" class="form-label fw-bold">{{ $attr->name }}</label>
                                        <div class="attribute-list d-flex">
                                            @foreach ($attr->values as $value)
                                                @if ($attr->type == 0) {{-- text attribute --}}
                                                    <div class="attribute-item text-attribute p-2 text-center text-capitalize" 
                                                    data-toggle="tooltip" title="{{ $value->name }}"
                                                    data-id="{{ $value->id }}">{{ $value->name }}</div>
                                                @endif
                                                @if ($attr->type == 1) {{-- color attribute--}}
                                                    <div class="attribute-item p-2 text-center color-attribute rounded-circle" 
                                                    data-toggle="tooltip" title="{{ $value->name }}"
                                                    data-id="{{ $value->id }}" style="background-color: {{ $value->value }}"></div>
                                                @endif
                                                @if ($attr->type == 2) {{-- color attribute--}}
                                                <div class="attribute-item p-2 text-center image-attribute img-rounded img-thumbnail" 
                                                data-toggle="tooltip" title="{{ $value->name }}"
                                                data-id="{{ $value->id }}" style="background-image: url({{ $value->image->getFileFullPath() }})"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-container">
                <x-products-display :products="$products"/>
            </div>
        </div>
    </main>

    <script>
    $(function() {
            var categoryId = '';
            const search = function() {
                var searchWord = $('#search').val();

                $.ajax({
                    url: "{{ url('/searchCategory') }}",
                    data: {
                        q: searchWord,
                        category: categoryId
                    },
                    success: function(data) {
                        $('div.product-container').html(data);
                    }
                })
            }

            $('li.category').click(function() {
                var _this = this;
                $('ul.category-container').find('li.category').each(function() {
                    $(this).removeClass('active');
                    $(_this).addClass('active');
                });

                categoryId = $(_this).attr('data-category');
                $('#category_id').val(categoryId);

                search();
            });
        })
    </script>
</div>
