	
	<div class="form-group">
	
		@include('crud.fields.varchar.label')
		
		@isset($row)
		
			<input type="text" class="form-control col-md-9" id="{{ $field->code }}Input" name="{{ $field->code }}" value="{{ old($field->code, $row->{$field->code}) }}">
			
		@else
			
			<input type="text" class="form-control col-md-9" id="{{ $field->code }}Input" name="{{ $field->code }}" value="{{ old($field->code, $field->default_value) }}">
			
		@endisset
		    
	</div>