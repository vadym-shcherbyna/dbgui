	
	@if($items->total()  > 10)
								
		<small>{{ $items->count() }} items of {{ $items->total() }}</small>				 		
		
	@else

		<small>Total items: {{ $items->total() }}</small>
		
	@endif