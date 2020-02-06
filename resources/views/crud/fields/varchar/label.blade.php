	
	<label for="{{ $field->code }}Input">
	
		{{ $field->name }}
		
		@if($field->flag_required)
			
			<strong class="text-danger">*</strong>			
		
		@endif
		
	</label>