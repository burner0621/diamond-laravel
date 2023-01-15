@if ($product)
    @method('put')
@endif
<div class="col-md-12 mb-2">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="{{ $product->name ?? old('name')}}" class="form-control">
</div>
<div class="col-md-12 mb-2">
    <label for="desc">Description:</label>
    <textarea name="desc" id="desc" rows="3" class="form-control">
        {{ $product->desc ?? old('desc')}}
    </textarea>
</div>
<div class="col-md-6 mb-2">
    <label for="price">Price:</label>
    <input type="text" name="price" id="price" value="{{ $product->price ?? old('price') }}" class="form-control" placeholder="80.00...">
</div>
<div class="col-md-6 mb-2">
    <label for="qty">Quantity in Stock:</label>
    <input type="number" name="qty" id="qty" value="{{ $product->qty ?? old('qty') ?? 1}}" class="form-control" min="0">
</div>
<div class="col-md-12 mb-2">
    <label for="category">Category:</label>
    <select name="category" id="category" value="{{ $product->category ?? old('category')}}" class="form-select">
        @foreach (App\Models\Product::$category_list as $category)
            <option {{
                isset($product)
                && $product->category == $category
                ?  
                'selected'
                :
                null
            }}>
                {{$category}}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-12 mb-3">
    <label for="images">{{ is_Null($product) ? 'Images' : 'Replace Images' }}:</label>
    <input type="file" name="images[]" id="images" class="form-control" multiple>
</div>
<div class="col-md-12 text-center">
    <button type="submit" class="btn btn-lg btn-outline-success">{{ is_Null($product) ? 'Add' : 'Edit' }}</button>
</div>
