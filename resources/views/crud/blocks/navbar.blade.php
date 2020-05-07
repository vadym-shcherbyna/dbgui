<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">

	<a class="navbar-brand" href="{{env('APP_URL')}}"><i class="fas fa-database fa-fw mr-2"></i> @lang('crud.brand')</a>

	<ul class="navbar-nav mr-auto ml-5">
		@foreach($languages as $language)

			@if ($language == $lang)
				<a class="nav-link" href="{{ route('lang', $language) }}"><strong>@lang('crud.languages.'.$language)</strong></a>
			@else
				<a class="nav-link" href="{{ route('lang', $language) }}">@lang('crud.languages.'.$language)</a>
			@endif
		@endforeach
	</ul>

	<ul class="navbar-nav ml-auto">

		@auth
			<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2"><i class="fas fa-user fa-fw mr-2"></i> {{ Auth::user()->email }}</span></a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-fw mr-2"></i> @lang('crud.auth.logout.title')</a>
			</div>
		</li>
	@endauth

	@guest
		<li class="nav-item">
			<a class="nav-link" href="{{ route('auth.login') }}">@lang('crud.auth.login.title')</a>
		</li>
	@endguest

	</ul>

</nav>