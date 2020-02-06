		
	@extends('crud.layout')
	
	@section('css', '')			
	
	@section('js', '')			
	
	@section('content')		
	
		<div class="row">
		
			<div class="col-md-4">
							
				<div class="card mb-4">
	  
					<div class="card-header">
		
						<i class="fas fa-sign-in-alt fa-fw mr-2"></i> <strong>Login</strong>
						
					</div>
					
					<div class="card-body">
					
						@if ($errors->any())
							
							<div class="alert alert-danger">
							
								<ul class="mb-0">
								
									@foreach ($errors->all() as $error)
									
										<li>{{ $error }}</li>
								
									@endforeach
								
								</ul>
							
							</div>
						
						@endif					
												
						<form method="POST" action="{{ route('login') }}">
						
							 @csrf
				
							<div class="form-group">
						
								<div class="input-group">
								
									<div class="input-group-prepend">
									
										<div class="input-group-text"><i class="fas fa-envelope fa-fw"></i></div>
									
									</div>      						
						
									<input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" />						
								
								</div>
				
							</div>
						
							<div class="form-group">
						
								<div class="input-group">
								
									<div class="input-group-prepend">
									
										<div class="input-group-text"><i class="fas fa-lock fa-fw"></i></div>
									
									</div>      						
						
									<input type="password" class="form-control" name="password" placeholder="Password" />			  	
								
								</div>
				
							</div>										
						
							<div class="form-group">
						
								<div class="form-check form-check-inline">
									
									<input type="hidden" name="remember" value="0" />
							
									<input class="form-check-input" type="checkbox" name="remember" id="rememberInput" value="1" checked>
							
									<label class="form-check-label cursor-pointer" for="rememberInput">remember me</label>
						
								</div>						
						
							</div>
						
							<div class="row">
				
								<div class="col-md-12">	
					
									<button type="submit" class="btn btn-secondary form-control ">Login</button>
						
								</div>
					
							</div>						

						</form>			
			
					</div>				
					
				</div>						
					
			</div>					
		
		</div>				
					
	@endsection						
