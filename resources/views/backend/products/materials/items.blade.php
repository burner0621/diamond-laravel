@foreach ($arrMaterials as $material)
    <div class="card col-md-12 mb-6">
        <!-- Header -->
        <div class="card-header">
            <h4 class="card-header-title mb-0">{{ $material->name }}</h4>
            <a href="{{ route('backend.products.product_materials', $product->id) }}"
               class="btn btn-sm btn-primary btn-add-material-modal">Add {{ $material->name }}</a>
        </div>
        <!-- End Header -->

        <div class="card-body row">
            <table class="table table-thead-bordered table-nowrap table-align-middle card-table table-responsive no-footer">
                <thead>
                @if($material->id == 1)
                    <tr>
                        <th>Diamond</th>
                        <th>Diamond size</th>
                        <th>Diamond amount</th>
                        <th>Clarity</th>
                        <th>Color</th>
                        <th>Lab Price</th>
                        <th>Natural Price</th>
                    </tr>
                @else
                    <tr>
                        <th>Material</th>
                        <th>Material Weight</th>
                    </tr>
                @endif
                </thead>

                <tbody class="meterial_list_{{$material->id}}">
                @php
                    $cur_product_attribute_value_id = -1;
                @endphp
                @foreach($product_materials = $product->product_materials_by_material_id($material->id) as $k => $product_material)
                    @if($product_material->product_attribute_value_id != $cur_product_attribute_value_id)
                        <tr data-{{ $material->id == 1 ? 'diamond' : 'metal' }}-attribute-value-id="{{ $product_material->product_attribute_value_id }}">
                            @if(count($product_materials) == 0)
                                <div class="text-danger">No Data to display</div>
                            @else
                                <td colspan="{{ $material->id == 1 ? 8 : 3 }}">
                                    <div class="text-primary">{{ $product_material->attribute_name ? $product_material->attribute_name : 'No Attribute' }}</div>
                                </td>
                            @endif
                        </tr>
                    @endif
                    @if($material->id == 1)
                        <tr>
                            <td>
                                {{ $product_material->material_type->type }}
                            </td>
                            <td>
                                @foreach($arrDiamondTypes as $material_type_diamond)
                                    @if($material_type_diamond->material_id == $product_material->material_id && $material_type_diamond->material_type_id == $product_material->material_type_id)
                                        @if($material_type_diamond->id == $product_material->diamond_id)
                                            {{ $material_type_diamond->mm_size }}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                {{ $product_material->diamond_amount }}
                            </td>
                            <td>
                                @foreach($arrDiamondTypeClarity as $material_type_diamonds_clarity)
                                    @if($material_type_diamonds_clarity->id == $product_material->material_type_diamonds_price($product_material->diamond_id)->material_type_diamonds_clarity->id)
                                        {{ $material_type_diamonds_clarity->clarity_name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($arrDiamondTypeColors as $material_type_diamonds_color)
                                    @if($material_type_diamonds_color->id == $product_material->material_type_diamonds_price($product_material->diamond_id)->material_type_diamonds_color->id)
                                        {{ $material_type_diamonds_color->color_name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                {{ $product_material->material_type_diamonds_price($product_material->diamond_id)->natural_price }}
                            </td>
                            <td>
                                {{ $product_material->material_type_diamonds_price($product_material->diamond_id)->lab_price }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                {{ $product_material->material_type->type }}
                            </td>
                            <td>
                                {{ $product_material->material_weight }}
                            </td>
                        </tr>
                    @endif
                    @php
                        $cur_product_attribute_value_id = $product_material->product_attribute_value_id;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('backend.products.materials.add_material')
    @include('backend.products.materials.edit_material')
@endforeach
