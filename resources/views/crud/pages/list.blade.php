@extends('crud.content.main')
@section('info')
	<div class="row">
		<div class="col-md-12">
			<div class="card">

				<div class="card-header">
					@include('crud.pages.subview.submenu')
				</div>

				<div class="card-body">

					<div class="form-inline mb-4">
						@foreach ($table->filters as $filter)
							@include('crud.fields.'.$filter->type->code.'.filter', ['field'=> $filter,  'table'=>$table])
						@endforeach
					</div>

					@if($items->count() == 0)

						<div class="alert alert-warning" role="alert">
							@lang('crud.no_data')
						</div>

					@else

						<table class="table">

							<thead>
								<tr>
									<th>#</th>
									@foreach($table->fieldsView as $col)
										<th>
											@if($col->type->flag_sorted)
												@if($col->code == $sortingField)
													<a href="{{route('items.sort', [$table->url, $col->id, $direction])}}">
													@if($sortingDirection == 'ASC')
														<i class="fas fa-sort-alpha-down fa-fw"></i>
													@else
														<i class="fas fa-sort-alpha-up fa-fw"></i>
													@endif
												@else
													<a href="{{route('items.sort', [$table->url, $col->id, 'asc'])}}">
												@endif
												{{ $col->name }}</a>
											@else
												{{ $col->name }}
											@endif
										</th>
									@endforeach
									<th>@lang('crud.items.list.actions')</th>
								</tr>
							</thead>

							<tbody>
								@foreach($items as $item)
									<tr>
										<td>{{ $item->id }}</td>
										@foreach($table->fieldsView as $col)
											<td>@include('crud.fields.'.$col->type->code.'.view', ['data'=> $item->{$col->code}])</td>
										@endforeach
										<td class="text-nowrap">
											<a href="{{route('items.edit', [$table->url, $item->id])}}">
												<button type="button" class="btn btn-light btn-sm text-success mr-2"><i class="fas fa-edit fa-fw"></i></button></a>
											<a href="{{route('items.delete', [$table->url, $item->id])}}" onclick="return confirm ('@lang('crud.items.list.delete_message')')">
												<button type="button" class="btn btn-light btn-sm text-danger"><i class="fas fa-trash fa-fw"></i></button></a>
										</td>
									</tr>
								@endforeach
							</tbody>

						</table>

					@endif
				</div>

				<div class="card-footer">

					<div class="row">

						<div class="col-md-8 float-left">

							{{ $items->links() }}

						</div>

						<div class="col-md-2 float-right">

							@include('crud.pages.subview.numrows')

						</div>

						<div class="col-md-2 float-right">

							@include('crud.pages.subview.pagination')

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

@endsection
