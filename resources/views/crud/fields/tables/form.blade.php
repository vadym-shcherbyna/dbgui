<div class="form-group">

    @include('crud.fields.varchar.label')

    <select class="form-control col-md-6" id="{{ $field->code }}_input"  name="{{ $field->code }}">

        @if($field->flag_required)
        @else
            <option value="0"></option>
        @endif

        @foreach($field->options as $option)
            @isset($item)
                <option value="{{ $option->id }}" @if($option->id ==  old($field->code, $item->{$field->code})) selected @endif>{{ $option->name }}</option>
            @else
                <option value="{{ $option->id }}" @if($option->id ==  old($field->code, $field->default_value)) selected @endif>{{ $option->name }}</option>
            @endisset
        @endforeach

    </select>

</div>