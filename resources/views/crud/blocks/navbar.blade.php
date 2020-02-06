			
			<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">

				<a class="navbar-brand" href="/"><i class="fas fa-database fa-fw mr-2"></i> DB GUI</a>
				
				<ul class="navbar-nav ml-auto">

				@auth
				
					<li class="nav-item dropdown">
						
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						
							<span class="mr-2"><i class="fas fa-user fa-fw mr-2"></i> {{ Auth::user()->email }}</span></a>
						
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
						
							<a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-fw mr-2"></i> Logout</a>

						</div>
						
					</li>
					
				@endauth
				
				@guest

					<li class="nav-item">
						
						<a class="nav-link" href="{{ route('login') }}">Login</a>
						
					</li>	
					
				@endguest
		
			</nav>