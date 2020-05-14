<div class="form-group">

    @include('crud.fields.varchar.label')

    <input type="file" class="form-control-file" id="{{ $field->code }}_input" name="{{ $field->code }}">

    @isset($item)

        <input type="hidden" name="{{ $field->code }}" value="{{ $item->{$field->code} }}">

        @isset($field->preview)

            <img src="{{ $field->preview->path }}" width="{{$field->preview->width}}" height="{{$field->preview->height}}" class="img-thumbnail mt-2">

        @endisset

    @endisset

</div>