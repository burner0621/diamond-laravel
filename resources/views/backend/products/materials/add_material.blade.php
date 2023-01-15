<!-- Add Material Modal -->
<style>
    .select2-dropdown {
        z-index: 99999;
    }
</style>
<div class="modal fade" id="modalAddMaterial{{ $material->id }}" data-material_id="{{ $material->id }}" tabindex="-1"
     aria-labelledby="momdalAddMaterialLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="momdalAddMaterialLabel">Add {{ $material->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            @if ($material->id == 1)
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name">Attributes values:</label>
                        <select id="selectAttributeValues" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">

                            @include('backend.products.attributes.values.ajax',[
                                'attributes' => $selected_values,
                                'values_selected' => $values_selected,
                                'can_select_other_options' => false
                            ])
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="selMaterialType" class="col-form-label">Diamond Types:</label>
                        <select id="selMaterialType" class="form-control">
                            @foreach ($material->types as $material_type)
                                <option value="{{ $material_type->id }}">{{ $material_type->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="DiamondSize" class="col-form-label">Diamond Size:</label>
                        <select id="DiamondSize" name="DiamondSize" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                            @if(isset($arrDiamondTypes) && count($arrDiamondTypes) > 0)
                                @foreach ($arrDiamondTypes as $diamondType)
                                    <option value="{{ $diamondType->id }}">{{ $diamondType->mm_size }} mm</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-3" id="sizeSetValues">
                    </div>
                </div>
            @else

                <div class="modal-body">
                    <div class="mb-4">
                        <label for="name">Select Variant:</label>
                        <select id="selAttributes" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">
                            @foreach ($attributes as $attribute)
                                @if(in_array($attribute->id, $attributes_selected))
                                    <option value="{{ $attribute->id }}" selected data-tokens="{{ $attribute->name }}">
                                        {{ $attribute->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name">Attributes values:</label>
                        <select id="selAttributeValues" value="" class="form-control select2"
                                multiple="multiple" style="width: 100%;">

                            @include('backend.products.attributes.values.ajax',[
                                'attributes' => $selected_values,
                                'values_selected' => $values_selected,
                                'can_select_other_options' => false
                            ])
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="selMaterialType" class="col-form-label">Material Types:</label>
                        <select id="selMaterialType" class="form-control">
                            @foreach ($material->types as $material_type)
                                <option value="{{ $material_type->id }}">{{ $material_type->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="selMaterialWeightArea">
                        @foreach($selected_values as $selected_value)
                            @foreach($selected_value->values as $value)
                                @if(isset($values_selected) && in_array($value->id, $values_selected))
                                    <div class="mb-3">
                                        <input type="hidden" name="txtAttributeValueIds[]" value="{{ $value->id }}">
                                        <label for="txtMaterialWeight_{{ $value->id }}" class="col-form-label">Material Weight ({{ $selected_value->name . " " . $value->name }}):</label>
                                        <input type="text" class="form-control" id="txtMaterialWeight_{{ $value->id }}" value="">
                                    </div>
                                @endif
                            @endforeach
                        @endforeach

                        @if(isset($values_selected) && in_array("", $values_selected))
                            <div class="mb-3">
                                <input type="hidden" name="txtAttributeValueIds[]" value="0">
                                <label for="txtMaterialWeight_0" class="col-form-label">Material Weight:</label>
                                <input type="text" class="form-control" id="txtMaterialWeight_0" value="">
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" class="btn btn-primary btn-add-material"
                        data-material-id="{{ $material->id }}">Add</button>
            </div>
        </div>
    </div>
</div>
<script>
  let selected_attributes = @json($selected_values);
  $(document).ready(function () {

    $('#selAttributeValues').on('change', function (e) {
      let new_html = ''

      if($('#selAttributeValues').val().length == 0){
        new_html = '<div class="mb-3"><input type="hidden" name="txtAttributeValueIds[]" value="0">' +
          '<label for="txtMaterialWeight_0" class="col-form-label">Material Weight:</label>' +
          '<input type="text" class="form-control" id="txtMaterialWeight_0" value="">' +
          '</div>'
      }

      for(let i=0; i<selected_attributes.length; i++){
        for(let j=0; j<selected_attributes[i].values.length; j++){
          if($('#selAttributeValues').val().includes(String(selected_attributes[i].values[j].id))){
            new_html += '<div class="mb-3"><input type="hidden" name="txtAttributeValueIds[]" value="'+ selected_attributes[i].values[j].id  +'">' +
              '<label for="txtMaterialWeight_' + selected_attributes[i].values[j].id +'" class="col-form-label">Material Weight ('+ selected_attributes[i].name + ' ' + selected_attributes[i].values[j].name +'):</label>' +
              '<input type="text" class="form-control" id="txtMaterialWeight_' + selected_attributes[i].values[j].id + '" value="">' +
            '</div>'
          }
        }
      }

      $('#selMaterialWeightArea').html(new_html)
    })
  });
</script>