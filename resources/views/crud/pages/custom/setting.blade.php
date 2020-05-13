@extends('crud.content.main')

@section('info')

	<div class="row">

		<div class="col-md-12">

			<div class="card">

				<div class="card-header">

					<ul class="nav nav-tabs card-header-tabs">

						<li class="nav-item">
							<a class="nav-link active" href="{{route('settings.list')}}"><i class="fas fa-list fa-fw mr-2"></i> Settings</a>
						</li>

					</ul>

				</div>

				<div class="card-body">


					<form action="{{route('settings.list')}}" method="POST" enctype="multipart/form-data">

						 @csrf

						@foreach($settings  as $setting)

							@if($setting->type == 'flag')

								<div class="form-group row">
									<div class="col-sm-4">@lang('crud.settings.list.'.$setting->code)</div>
									<div class="col-sm-8">
										<div class="form-check">
											<input type="hidden" name="{{$setting->code}}" value="0">
											<input type="checkbox" name="{{$setting->code}}" id="{{$setting->code}}" value="1"  @if($setting->value == 1) checked @endif class="form-check-input">
											<label class="form-check-label cursor-pointer" for="{{$setting->code}}">
												@lang('crud.settings.list.'.$setting->code)
											</label>
										</div>
									</div>
								</div>

							@endif

							@if($setting->type == 'integer')

								<div class="form-group row">
									<label for="{{$setting->code}}" class="col-sm-4 col-form-label">@lang('crud.settings.list.'.$setting->code)</label>
									<div class="col-sm-2">
										<input type="number" step="1" min="1" class="form-control" id="{{$setting->code}}" name="{{$setting->code}}" value="{{$setting->value}}">
									</div>
								</div>

							@endif

						@endforeach

						<div class="form-group">
							<button type="submit" class="btn btn-secondary">@lang('crud.save')</button>
							<a href="{{route('settings.default')}}" onclick="return confirm ('@lang('crud.settings.list.default_message')')"><button type="button" class="btn btn-light  ml-2">@lang('crud.settings.list.default')</button></a>
						</div>

					</form>


				</div>

			</div>

		</div>

	</div>

@endsection
