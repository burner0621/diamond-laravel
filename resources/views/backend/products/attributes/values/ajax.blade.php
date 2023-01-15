@foreach ($attributes as $attribute)
    <option disabled> ---- Values for {{$attribute->name}} ----</option>
    @foreach ($attribute->values as $value)
        @if(isset($can_select_other_options) && !$can_select_other_options)
            @if(isset($values_selected) && in_array($value->id, $values_selected))
                <option value="{{ $value->id }}" selected
                        data-tokens="{{ $value->name }}">
                    {{$attribute->name}} : {{ $value->name }}</option>
            @endif
        @else
            <option value="{{ $value->id }}"
                    @if(isset($values_selected) && in_array($value->id, $values_selected)) selected @endif
                    data-tokens="{{ $value->name }}">
                {{$attribute->name}} : {{ $value->name }}</option>
        @endif
    @endforeach
@endforeach
