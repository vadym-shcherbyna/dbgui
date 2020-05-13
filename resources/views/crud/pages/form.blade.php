@extends('crud.content.main')
@section('info')
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    @include('crud.pages.subview.submenu')
                </div>

                <div class="card-body">

                    @if($mode == 'add')
                        <form action="{{route('items.add', $table->url)}}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{route('items.edit', [$table->url, $item->id])}}" method="POST" enctype="multipart/form-data">
                    @endif

                         @csrf

                        @include('crud.pages.subview.errors')

                        @if($mode == 'add')
                            @foreach ($table->fields as $field)
                                @include('crud.fields.'.$field->type->code.'.form', ['field' => $field])
                            @endforeach
                        @else
                            @foreach ($table->fieldsEdit as $field)
                                @include('crud.fields.'.$field->type->code.'.form', ['field' => $field, 'item' => $item])
                            @endforeach
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary">@lang('crud.'.$mode)</button>
                            <a href="{{route('items.list', $table->url)}}"><button type="button" class="btn btn-light  ml-2">@lang('crud.cancel')</button></a>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
