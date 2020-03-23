@extends('crud.layout')

@section('css', '')

@section('javascript', '')

@section('content')
			
	<div class="row mb-3">

		<div class="col-md-3">
			@include('crud.blocks.menu')
		</div>

		<div class="col-md-9">
			@yield('info')
		</div>

	</div>
					
@endsection