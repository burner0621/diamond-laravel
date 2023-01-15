@extends('backend.layouts.app', ['activePage' => 'products', 'title' => 'Edit Product', 'navName' => 'Table List', 'activeButton' => 'catalogue'])
@section('css_content')
    <style>
        .select2-dropdown {
            z-index: 99999;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-30px">
        <div class="d-flex align-items-end">
            <img src="{{ $product->uploads->getImageOptimizedFullName(400) }}" class="w-50px">
            <h2>{{ $product->name }}</h2>
        </div>

        <a href="{{ route('backend.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Back to product</a>
    </div>

    <form method="POST" action="{{ route('backend.products.update_product_materials') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        @foreach($materials as $material)
            <div class="d-flex justify-content-between align-items-center">
                <h3>{{ $material->name }}</h3>
                <button class="btn btn-sm btn-primary btn-add-material-modal" type="button" data-bs-toggle="modal"
                        data-bs-target="#{{ $material->id == 1 ? 'add_diamond_modal' : 'add_metal_modal' }}">
                    Add {{ $material->name }}</button>
            </div>
            <div class="table-responsive mb-20px">
                <table class="table table-bordered table-responsive"
                       id="{{ $material->id == 1 ? 'diamond_table' : 'metal_table' }}">
                    <thead>
                    <tr>
                        @if($material->id == 1)
                            <th>Diamond</th>
                            <th>Diamond Size</th>
                            <th>Diamond Amount</th>
                            <th>Clarity</th>
                            <th>Color</th>
                            <th>Lab Price</th>
                            <th>Natural Price</th>
                            <th>Action</th>
                        @else
                            <th>Material</th>
                            <th>Material Weight</th>
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody style="font-size: 1rem; vertical-align: middle;">
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
                            <tr data-product-material-id="{{ $product_material->id }}"
                                data-unique-key="{{ $product_material->product_attribute_value_id . '_' . $product_material->material_type_id . '_' . $product_material->diamond_id }}"
                                data-diamond-attribute-value-id="{{ $product_material->product_attribute_value_id }}">
                                <td>
                                    {{ $product_material->material_type->type }}
                                    <input type="hidden" name="product_material_id[]"
                                           value="{{ $product_material->id }}">
                                    <input type="hidden" name="material_type_id[]"
                                           value="{{ $product_material->material_type_id }}">
                                    <input type="hidden" name="product_attribute_value_id[]"
                                           value="{{ $product_material->product_attribute_value_id }}">
                                </td>
                                <td>
                                    <select name="material_type_diamonds_id[]" class="form-control select2">
                                        @foreach($material_type_diamonds as $material_type_diamond)
                                            @if($material_type_diamond->material_id == $product_material->material_id && $material_type_diamond->material_type_id == $product_material->material_type_id)
                                                <option value="{{ $material_type_diamond->id }}" {{ $material_type_diamond->id == $product_material->diamond_id ? 'selected' : '' }}>{{ $material_type_diamond->mm_size }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="diamond_amount[]"
                                           value="{{ $product_material->diamond_amount }}" class="form-control">
                                </td>
                                <td>
                                    <select class="form-control select2" name="material_type_diamonds_clarity_id[]">
                                        @foreach($material_type_diamonds_clarities as $material_type_diamonds_clarity)
                                            <option value="{{ $material_type_diamonds_clarity->id }}" {{ $material_type_diamonds_clarity->id == $product_material->material_type_diamonds_price($product_material->diamond_id)->material_type_diamonds_clarity->id ? 'selected' : '' }}>
                                                {{ $material_type_diamonds_clarity->clarity_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="material_type_diamonds_color_id[]">
                                        @foreach($material_type_diamonds_colors as $material_type_diamonds_color)
                                            <option value="{{ $material_type_diamonds_color->id }}" {{ $material_type_diamonds_color->id == $product_material->material_type_diamonds_price($product_material->diamond_id)->material_type_diamonds_color->id ? 'selected' : '' }}>
                                                {{ $material_type_diamonds_color->color_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input class="form-control" type="number"
                                           name="material_type_diamonds_lab_price[]"
                                           value="{{ $product_material->material_type_diamonds_price($product_material->diamond_id)->lab_price }}">
                                </td>
                                <td><input class="form-control" type="number" name="material_type_diamonds_natural_price[]"
                                           value="{{ $product_material->material_type_diamonds_price($product_material->diamond_id)->natural_price }}">
                                </td>
                                <td>
                                    <button class="form-control btn btn-danger btn-sm"
                                            onclick="delete_current_row(this)">Delete
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr data-product-material-id="{{ $product_material->id }}"
                                data-unique-key="metal_{{ $product_material->product_attribute_value_id . '_' . $product_material->material_type_id }}"
                                data-metal-attribute-value-id="{{ $product_material->product_attribute_value_id }}">
                                <td>
                                    {{ $product_material->material_type->type }}
                                    <input type="hidden" name="metal_product_material_id[]"
                                           value="{{ $product_material->id }}">
                                    <input type="hidden" name="metal_material_type_id[]"
                                           value="{{ $product_material->material_type_id }}">
                                    <input type="hidden" name="metal_product_attribute_value_id[]"
                                           value="{{ $product_material->product_attribute_value_id }}">
                                </td>
                                <td>
                                    <input type="number" inputmode="decimal" step="0.01" name="material_weight[]"
                                           value="{{ $product_material->material_weight }}" class="form-control">
                                </td>
                                <td>
                                    <button class="form-control btn btn-danger btn-sm"
                                            onclick="delete_current_metal_row(this)">Delete
                                    </button>
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
        @endforeach

        <div class="text-right">
            <button class="btn btn-success ml-auto" type="submit">Update</button>
        </div>
    </form>


    <div id="add_diamond_modal" class="modal modal-lg fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="font-size: 1rem;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="momdalAddMaterialLabel">Add Diamond</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="diamond_attribute_values_select">Attribute values:</label>
                        <select id="diamond_attribute_values_select" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                            @include('backend.products.attributes.values.ajax',[
                                'attributes' => $product_attributes,
                                'values_selected' => explode(',', $product->product_attribute_values),
                                'can_select_other_options' => false
                            ])
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="material_type_select">Diamond Type</label>
                        <select id="material_type_select" class="form-control">
                            @foreach($material_types as $material_type)
                                @if($material_type->material_id == 1)
                                    <option value="{{ $material_type->id }}">{{ $material_type->type }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="material_type_diamond_select">Diamond Size</label>
                        <select id="material_type_diamond_select" class="form-control select2" multiple="multiple"
                                style="width: 100%;">
                            @foreach($material_type_diamonds as $material_type_diamond)
                                @if($material_types[0]->id == $material_type_diamond->material_type_id && $material_types[0]->material_id == $material_type_diamond->material_id)
                                    <option value="{{ $material_type_diamond->id }}">{{ $material_type_diamond->mm_size }}
                                        mm
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel
                    </button>
                    <button type="button" class="btn btn-primary btn-add-material"
                            onclick="add_diamond_product_materials()">Add
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="add_metal_modal" class="modal modal-lg fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="font-size: 1rem;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="momdalAddMaterialLabel">Add Metal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="metal_attribute_values_select">Attribute values:</label>
                        <select id="metal_attribute_values_select" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                            @include('backend.products.attributes.values.ajax',[
                                'attributes' => $product_attributes,
                                'values_selected' => explode(',', $product->product_attribute_values),
                                'can_select_other_options' => false
                            ])
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="metal_material_type_select">Material Type</label>
                        <select id="metal_material_type_select" class="form-control">
                            @foreach($material_types as $material_type)
                                @if($material_type->material_id == 2)
                                    <option value="{{ $material_type->id }}">{{ $material_type->type }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel
                    </button>
                    <button type="button" class="btn btn-primary btn-add-material"
                            onclick="add_metal_product_materials()">Add
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js_content')
    <script>
      let product_materials = @json($product_materials);
      let material_types = @json($material_types);
      let material_type_diamonds = @json($material_type_diamonds);
      let material_type_diamonds_clarities = @json($material_type_diamonds_clarities);
      let material_type_diamonds_colors = @json($material_type_diamonds_colors);
      let material_type_diamonds_prices = @json($material_type_diamonds_prices);
      let attribute_values = @json($attribute_values);

      $('.select2').select2({
        tags: true,
        maximumSelectionLength: 10,
        tokenSeparators: [','],
        placeholder: "Select or type keywords",
      })

      let add_diamond_product_materials = function () {
        let diamond_attribute_values = $('#diamond_attribute_values_select').val().length ? $('#diamond_attribute_values_select').val() : [0];
        let diamond_material_type_value = $('#material_type_select').val();
        let diamond_material_type_diamonds_values = $('#material_type_diamond_select').val();
        let new_html = ''

        let attribute_value, diamond, material_type, material_type_diamonds_price;
        for (let i = 0; i < diamond_attribute_values.length; i++) {
          for (let j = 0; j < diamond_material_type_diamonds_values.length; j++) {
            new_html = '';
            /* if product_material already existed */
            if (!$('tr[data-unique-key="' + diamond_attribute_values[i] + '_' + diamond_material_type_value + '_' + diamond_material_type_diamonds_values[j] + '"]').length) {
              attribute_value = attribute_values.find(attribute_value => attribute_value.id == diamond_attribute_values[i])
              diamond = material_type_diamonds.find(material_type_diamond => material_type_diamond.id == diamond_material_type_diamonds_values[j])
              material_type = material_types.find(material_type => material_type.id == diamond_material_type_value)

              /* if current attribute_value id is not in current table */
              if ($('tr[data-diamond-attribute-value-id="' + diamond_attribute_values[i] + '"]').length == 0) {
                new_html = '<tr data-diamond-attribute-value-id="' + diamond_attribute_values[i] + '"><td colspan="7"><div class="text-primary">' + (attribute_value ? attribute_value.value + ' ' + attribute_value.name : 'No Attribute') + '</div></td></tr>'
              }

              new_html += '<tr data-product-material-id="0" data-unique-key="' + diamond_attribute_values[i] + '_' + diamond_material_type_value + '_' + diamond.id + '" data-diamond-attribute-value-id="' + diamond_attribute_values[i] + '">' +
                '<td>' + material_type.type +
                '<input type="hidden" name="product_material_id[]" value="0">' +
                '<input type="hidden" name="material_type_id[]" value="' + diamond_material_type_value + '">' +
                '<input type="hidden" name="product_attribute_value_id[]" value="' + diamond_attribute_values[i] + '">' +
                '</td>';
              new_html += '<td>' +
                '<select name="material_type_diamonds_id[]" class="form-control select2">';
              for (let k = 0; k < material_type_diamonds.length; k++) {
                if (material_type_diamonds[k].material_id == 1 && material_type_diamonds[k].material_type_id == diamond_material_type_value) {
                  new_html += '<option value="' + material_type_diamonds[k].id + '"' + (material_type_diamonds[k].id == diamond.id ? 'selected' : '') + '>' + material_type_diamonds[k].mm_size + '</option>'
                }
              }
              new_html += '</select></td>';

              new_html += '<td><input type="number" name="diamond_amount[]" class="form-control" value="0"></td>'

              material_type_diamonds_price = material_type_diamonds_prices.find(ele => ele.diamond_id == diamond.id)
              new_html += '<td><select class="form-control select2" name="material_type_diamonds_clarity_id[]">';
              for (k = 0; k < material_type_diamonds_clarities.length; k++) {
                new_html += '<option value="' + material_type_diamonds_clarities[k].id + '" ' + (material_type_diamonds_clarities[k].id == (material_type_diamonds_price ? material_type_diamonds_price.clarity : 3) ? 'selected' : '') + '>' + material_type_diamonds_clarities[k].name + '(' + material_type_diamonds_clarities[k].letters + ')' + '</option>'
              }
              new_html += '</select></td>';


              new_html += '<td><select class="form-control select2" name="material_type_diamonds_color_id[]">'
              for (k = 0; k < material_type_diamonds_colors.length; k++) {
                new_html += '<option value="' + material_type_diamonds_colors[k].id + '">' + material_type_diamonds_colors[k].name + ' ' + material_type_diamonds_colors[k].letters + '</option>'
              }
              new_html += '</select></td>'

              new_html += '<td><input class="form-control" type="number" name="material_type_diamonds_lab_price[]" value="' + (material_type_diamonds_price ? material_type_diamonds_price.lab_price : 0) + '"></td>'
              new_html += '<td><input class="form-control" type="number" name="material_type_diamonds_natural_price[]" value="' + (material_type_diamonds_price ? material_type_diamonds_price.natural_price : 0) + '"></td>'
              new_html += '<td><button class="form-control btn btn-danger btn-sm" onclick="delete_current_row(this)">Delete</button></td>'

              new_html += '</tr>';

              if ($('tr[data-diamond-attribute-value-id="' + diamond_attribute_values[i] + '"]').length) {
                $('tr[data-diamond-attribute-value-id="' + diamond_attribute_values[i] + '"]:last')[0].insertAdjacentHTML('afterend', new_html)
              } else {
                $('#diamond_table tbody')[0].insertAdjacentHTML('beforeend', new_html)
              }
            }
          }
        }

        $('#add_diamond_modal').modal('hide')

        $('#diamond_attribute_values_select').val([]).trigger("change");
        $('#material_type_diamond_select').val([]).trigger("change");

        $('.select2').select2({
          tags: true,
          maximumSelectionLength: 10,
          tokenSeparators: [','],
          placeholder: "Select or type keywords",
        })
      }

      let delete_current_row = function (ele) {
        let tr = ele.closest('tr')
        if ($('tr[data-diamond-attribute-value-id="' + tr.dataset.diamondAttributeValueId + '"]').length == 2) {
          $('tr[data-diamond-attribute-value-id="' + tr.dataset.diamondAttributeValueId + '"]').remove()
        }
        tr.remove()
      }

      let delete_current_metal_row = function (ele) {
        let tr = ele.closest('tr')
        if ($('tr[data-metal-attribute-value-id="' + tr.dataset.metalAttributeValueId + '"]').length == 2) {
          $('tr[data-metal-attribute-value-id="' + tr.dataset.metalAttributeValueId + '"]').remove()
        }
        tr.remove()
      }

      $('#material_type_select').on('change', function (e) {
        let newValue = e.target.value;
        let diamond_sizes = [];
        let optiondata = '';
        material_type_diamonds.map(function (item) {
          if (item.material_type_id == newValue) {
            optiondata += '<option value="' + item['id'] + '">' + item['mm_size'] + ' mm</option>';
          }
        })
        $('#material_type_diamond_select').html(optiondata);

        $('#material_type_diamond_select').val([]).trigger("change");
      })

      $('document').ready(function () {
        $('#diamond_attribute_values_select').val([]).trigger("change");
        $('#material_type_diamond_select').val([]).trigger("change");
        $('#metal_attribute_values_select').val([]).trigger('change');
      })

      let add_metal_product_materials = function () {
        let metal_attribute_values = $('#metal_attribute_values_select').val().length ? $('#metal_attribute_values_select').val() : [0]
        let metal_material_type_value = $('#metal_material_type_select').val();
        // debugger
        for (let i = 0; i < metal_attribute_values.length; i++) {
          new_html = '';
          /* if product_material already existed */
          if (!$('tr[data-unique-key="metal_' + metal_attribute_values[i] + '_' + metal_material_type_value + '"]').length) {
            attribute_value = attribute_values.find(attribute_value => attribute_value.id == metal_attribute_values[i])
            material_type = material_types.find(material_type => material_type.id == metal_material_type_value)

            /* if current attribute_value id is not in current table */
            if ($('tr[data-metal-attribute-value-id="' + metal_attribute_values[i] + '"]').length == 0) {
              new_html = '<tr data-metal-attribute-value-id="' + metal_attribute_values[i] + '"><td colspan="3"><div class="text-primary">' + (attribute_value ? attribute_value.value + ' ' + attribute_value.name : 'No Attribute') + '</div></td></tr>'
            }

            new_html += '<tr data-product-material-id="0" data-unique-key="metal_' + metal_attribute_values[i] + '_' + metal_material_type_value + '" data-metal-attribute-value-id="' + metal_attribute_values[i] + '">' +
              '<td>' + material_type.type +
              '<input type="hidden" name="metal_product_material_id[]" value="0">' +
              '<input type="hidden" name="metal_material_type_id[]" value="' + metal_material_type_value + '">' +
              '<input type="hidden" name="metal_product_attribute_value_id[]" value="' + metal_attribute_values[i] + '">' +
              '</td>';

            new_html += '<td><input class="form-control" inputmode="decimal" type="number" step="0.01" name="material_weight[]" value="0"></td>'
            new_html += '<td><button class="form-control btn btn-danger btn-sm" onclick="delete_current_metal_row(this)">Delete</button></td>'

            new_html += '</tr>';

            if ($('tr[data-metal-attribute-value-id="' + metal_attribute_values[i] + '"]').length) {
              $('tr[data-metal-attribute-value-id="' + metal_attribute_values[i] + '"]:last')[0].insertAdjacentHTML('afterend', new_html)
            } else {
              $('#metal_table tbody')[0].insertAdjacentHTML('beforeend', new_html)
            }
          }
        }

        $('#add_metal_modal').modal('hide')

        $('#metal_attribute_values_select').val([]).trigger("change");

        $('.select2').select2({
          tags: true,
          maximumSelectionLength: 10,
          tokenSeparators: [','],
          placeholder: "Select or type keywords",
        })
      }
    </script>
@endsection
