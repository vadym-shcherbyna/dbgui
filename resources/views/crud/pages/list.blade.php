		
	@extends('crud.content.main')
	
	@section('css', '')			
	
	@section('js', '')			
	
	@section('info')		
	
		<div class="row">				
				
			<div class="col-md-12">
					
				<div class="card">
					
					<div class="card-header">
						
						<ul class="nav nav-tabs card-header-tabs">
							
							<li class="nav-item">
								
								<a class="nav-link active" href="#"><i class="fas fa-list fa-fw mr-2"></i> List of {{ $table->name }}</a>
								
							</li>
							
							<li class="nav-item">
								
								<a class="nav-link" href="{{ env('APP_URL') }}/crud/{{ $table->url }}/add"><i class="fas fa-plus-square fa-fw mr-2"></i> Add  {{ $table->item_name }}</a>
								
							</li>
							
						</ul>
						
					</div>

					<div class="card-body">
					
						<div class="form-inline mb-4">
						
							@foreach ($table->filters as $filter)
									
								@include('crud.fields.'.$filter->type->code.'.filter', ['field'=> $filter,  'table'=>$table])
						
							@endforeach
														
						</div>	

						@if($items->count() == 0)
							
							<div class="alert alert-warning" role="alert">
							
								Items not found. You have to change filters.
								
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
												
														<a href="{{ env('APP_URL') }}/crud/{{ $table->url }}/sort/{{ $col->id }}/direction/{{ $direction }}">
													
														@if($sortingDirection == 'ASC')
														
															<i class="fas fa-sort-alpha-down fa-fw"></i>

														@else 
														
															<i class="fas fa-sort-alpha-up fa-fw"></i>
														
														@endif
												
													@else
													
														<a href="{{ env('APP_URL') }}/crud/{{ $table->url }}/sort/{{ $col->id }}/direction/asc">
													
													@endif
													
													{{ $col->name }}</a>
													
												@else
											
													{{ $col->name }}
										
												@endif
												
											</th>
										
										@endforeach
									
										<th>Actions</th>
									
									</tr>
								
								</thead>
							
								<tbody>
								
									@foreach($items as $item)
								
										<tr>
									
											<td>{{ $item->id }}</td>
										
											@foreach($table->fieldsView as $col)
											
												<td>@include('crud.fields.'.$col->type->code.'.view', ['data'=> $item->{$col->code}])</td>
											
											@endforeach
											
											<td>
											
												<a href="{{ env('APP_URL') }}/crud/{{ $table->url }}/edit/{{ $item->id }}">
												
													<button type="button" class="btn btn-light btn-sm text-success mr-2"><i class="fas fa-edit fa-fw"></i></button></a>
																							
												<a href="{{ env('APP_URL') }}/crud/{{ $table->url }}/delete/{{ $item->id }}" onclick="return confirm ('Delete item?')">
												
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
