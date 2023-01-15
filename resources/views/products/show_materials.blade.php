@php
    use App\Models\CurrentRate;
    $current_rate = CurrentRate::getLastRate();
@endphp

@if (count($arrProductMaterials))
    <div class="show-model-specs">
        <div class="show-specs-btn card rounded mb-3 text-uppercase fw-700 border p-3">
            Metal Weight
        </div>
    </div>

    <div class="show-model-data" id="showGold">
        <div class="row">
            @foreach ($arrProductMaterials as $product_material)
                @php
                    $type_name = $product_material->material_type_name;
                    $material_weight = $product_material->material_weight;
                    $material_dwt = $material_weight * 0.64301;

                    if ($current_rate == null) {
                        $price = 0;
                        $price_change = 0;
                    } else {
                        if (strpos($type_name ,'24K') !== false) {
                            $rate = $current_rate['24k'];
                        } else if (strpos($type_name ,'22K') !== false) {
                            $rate = $current_rate['22k'];
                        } else if (strpos($type_name ,'18K') !== false) {
                            $rate = $current_rate['18k'];
                        } else if (strpos($type_name ,'14K') !== false) {
                            $rate = $current_rate['14k'];
                        } else if (strpos($type_name ,'10K') !== false) {
                            $rate = $current_rate['10k'];
                        }

                        $price = number_format($material_weight * $rate, 2, '.', ',');
                    }
                @endphp

                <div class="col-lg-4 col-6 item-value-card-wrapper"
                     data-attribute-id="{{ $product_material->product_attribute_value_id == 0 ? 0 : $product_material->attribute->attribute->id }}"
                     data-attribute-value-id="{{ $product_material->product_attribute_value_id }}"
                >
                    <div class="border p-3 item-value-card card rounded mb-3">
                        <div class="item-value-card-body">
                            <div class="value-title pb-2 mb-2 text-uppercase fw-700">
                                {{ $type_name }}
                            </div>
                            <div class="py-1">
                                <span class="value-price">${{ $price }}</span>
                                {{-- <span class="value-price-change">{{ $price_change}}</span> --}}
                            </div>
                            <div class="py-1 fw-700 fs-24">{{ $material_weight }} Grams</div>
                            <div class="py-1 fw-700 fs-14">{{ $material_dwt }} DWT</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
