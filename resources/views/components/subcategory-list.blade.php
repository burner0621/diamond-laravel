<ul class="nav flex-column ms-3 category-list">
    @foreach ( $subcategories as $subcategory )
        <li class="nav-item category-item">
            @if (count($subcategory->subcategory) == 0)
                <label class="custom-checkbox-container">{{ $subcategory->category_name }}
                    <input type="checkbox" id="category-{{ $subcategory->id }}" value="{{ $subcategory->id }}">
                    <span class="checkmark"></span>
                </label>            
            @else
                <label class="custom-checkbox-container">{{ $subcategory->category_name }}
                    <input type="checkbox" id="category-{{ $subcategory->id }}" value="{{ $subcategory->id }}">
                    <span class="checkmark"></span>
                </label>
                @include('components.subcategory-list',['subcategories' => $subcategory->subcategory])
            @endif
        </li>
    @endforeach    
</ul>