@if(count($breadcrumbs) > 0)
	<nav>
		<ol class="breadcrumb mb-2 bg-light">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">@lang('crud.dashboard.title')</a></li>
			@foreach($breadcrumbs as $breadcrumb)
				@isset($breadcrumb['href'])
					<li class="breadcrumb-item"><a href="{{$breadcrumb['href']}}">{{$breadcrumb['name']}}</a></li>
				@else
					<li class="breadcrumb-item active">{{$breadcrumb['name']}}</li>
				@endisset
			@endforeach
		</ol>
	</nav>
@endif