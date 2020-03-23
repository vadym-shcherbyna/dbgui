<div class="form-group">

    @include('crud.fields.varchar.label')

    <input type="hidden" name="linked_data_id" id="linkedDataId" value="0">

    <select class="form-control col-md-6" id="fieldTypesSelect"  name="{{ $field->code }}">

        @foreach($field->options as $option)

            <option
                    value="{{ $option->id }}"
                    data-description="{{ $option->description }}"
                    data-code="{{ $option->code }}"
                    @if($option->id ==  old($field->code, $field->default_value)) selected @endif
            >{{ $option->name }}</option>

        @endforeach

    </select>

</div>

<div class="form-group d-none" id="linkedDataTablesLayout">

    <label for="linked_data_tables">Source Data Table <strong class="text-danger">*</strong></label>

    <select class="form-control col-md-6" id="linkedDataTables"  name="linked_data_tables">
        @if(count($field->linked_tables) === 0)
            <option value="0">No valid tables</option>
        @endif
        @foreach($field->linked_tables as $table)
            <option value="{{ $table->id }}">{{ $table->name }}</option>
        @endforeach
    </select>

</div>

@section('javascript')
    @parent
@endsection