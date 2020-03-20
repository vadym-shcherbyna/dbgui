<div class="form-group">

    @include('crud.fields.varchar.label')

    <select class="form-control col-md-6" id="fieldTypesSelect"  name="{{ $field->code }}">
        @foreach($field->options as $option)
            @isset($item)
                <option value="{{ $option->id }}" data-code="{{ $option->code }}" @if($option->id ==  old($field->code, $item->{$field->code})) selected @endif>{{ $option->name }}</option>
            @else
                <option value="{{ $option->id }}" data-code="{{ $option->code }}" @if($option->id ==  old($field->code, $field->default_value)) selected @endif>{{ $option->name }}</option>
            @endisset
        @endforeach
    </select>

</div>