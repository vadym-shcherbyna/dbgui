<div class="form-group">

    @include('crud.fields.varchar.label')

    <input type="datetime" class="form-control col-md-3" id="{{ $field->code }}_input" name="{{ $field->code }}"
        @isset($item)
            value="{{ old($field->code, $item->{$field->code}) }}">
        @else
            value="@php echo date('Y-m-d H:i:s'); @endphp">
        @endisset

</div>

