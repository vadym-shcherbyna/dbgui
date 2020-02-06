	
	<div class="form-group form-check">
	
		<input type="hidden" name="{{ $field->code }}" value="0">	
		
		@isset($row)
		
			<input type="checkbox" class="form-check-input" id="{{ $field->code }}Input" name="{{ $field->code }}" value="1" @if(old($field->code, $row->{$field->code})) checked @endif>
			
		@else
			
			<input type="checkbox" class="form-check-input" id="{{ $field->code }}Input" name="{{ $field->code }}" value="1" @if(old($field->code, $field->defaul_value)) checked @endif>
			
		@endisset
		
		<label class="form-check-label cursor-pointer" for="{{ $field->code }}Input">{{ $field->name }}</label>
		
	</div>	
