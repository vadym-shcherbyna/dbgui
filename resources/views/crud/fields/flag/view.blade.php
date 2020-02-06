
	<a href="{{ env('APP_URL') }}/crud/{{ $table->url }}/flag/{{ $col->id }}/id/{{ $item->id }}">

		@if($data == 1) 
					
			<i class="fas fa-check-square fa-fw"></i>
			
		@else
			
			<i class="fas fa-square fa-fw"></i>
			
		@endif

	</a>