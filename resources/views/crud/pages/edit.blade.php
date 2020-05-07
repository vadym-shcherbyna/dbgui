@extends('crud.content.main')
@section('info')
	<div class="row">
		<div class="col-md-12">
			<div class="card">

				<div class="card-header">
					@include('crud.pages.subview.submenu')
				</div>

				<div class="card-body">

					<form action="{{route('items.add', [$table->url, $item->id])}}" method="POST" enctype="multipart/form-data">

						 @csrf

						@include('crud.pages.subview.errors')

						@foreach ($table->fieldsEdit as $field)
							@include('crud.fields.'.$field->type->code.'.form', ['field' => $field, 'item' => $item])
						@endforeach

						<div class="form-group">
							<button type="submit" class="btn btn-secondary">@lang('crud.items.edit.submit')</button>
							<a href="{{route('items.list', $table->url)}}"><button type="button" class="btn btn-light  ml-2">@lang('crud.chancel')</button></a>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>
@endsection
