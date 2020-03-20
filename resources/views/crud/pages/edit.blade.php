		
	@extends('crud.content.main')
	
	@section('css', '')

	@section('javascript')
		@parent
	@endsection
	
	@section('info')		
	
		<div class="row">				
				
			<div class="col-md-12">
					
				<div class="card">
				
					<div class="card-header">
						
						<ul class="nav nav-tabs card-header-tabs">
							
							<li class="nav-item">
								<a class="nav-link" href="{{ env('APP_URL') }}/crud/{{ $table->url }}"><i class="fas fa-list fa-fw mr-2"></i> List of {{ $table->name }}</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" href="{{ env('APP_URL') }}/crud/{{ $table->url }}/add"><i class="fas fa-plus-square fa-fw mr-2"></i> Add  {{ $table->item_name }}</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link active" href="#"><i class="fas fa-edit fa-fw mr-2"></i> Edit  {{ $table->item_name }}</a>
							</li>							
							
						</ul>
						
					</div>
					
					<div class="card-body">

						
						<form action="{{ env('APP_URL') }}/crud/{{ $table->url }}/edit/{{ $item->id }}" method="POST" enctype="multipart/form-data">
						
							 @csrf
								 
							@if ($errors->any())
									
								<div class="alert alert-danger">
									
									<ul class="mb-0">
										
										@foreach ($errors->all() as $error)
											
											<li>{{ $error }}</li>
											
										@endforeach
											
									</ul>
										
								</div>
									
							@endif
																				
							@foreach ($table->fieldsEdit as $field)
														
								@include('crud.fields.'.$field->type->code.'.form', ['field' => $field, 'item' => $item])
								
							@endforeach
								
							<div class="form-group">
							
								<button type="submit" class="btn btn-secondary">Submit</button>
								
								<a href="{{ env('APP_URL') }}/crud/{{ $table->url }}"><button type="button" class="btn btn-light  ml-2">Cancel</button></a>
									
							</div>						

						</form>					
						
					
					</div>
					
				</div>					
		
			</div>
		
		</div>	
					
	@endsection						
