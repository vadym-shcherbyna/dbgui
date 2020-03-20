<div class="form-group">

    @include('crud.fields.varchar.label')

    <input type="number" step="1" class="form-control col-md-2" id="{{ $field->code }}_input" name="{{ $field->code }}"
        @isset($item)
            value="{{ old($field->code, $item->{$field->code}) }}">
        @else
            value="{{ old($field->code, $field->default_value) }}">
        @endisset

</div>