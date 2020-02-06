	
	<div class="form-group">
	
		@include('crud.fields.varchar.label')
		
		@if($field->options)
			
			<select class="form-control col-md-6" id="{{ $field->code }}Input"  name="{{ $field->code }}">
				
				@if($field->flag_required)
					
				@else
					
					<option value="0"></option>
					
				@endif
				
				@foreach($field->options as $option)
					
					@isset($row)
					
						<option value="{{ $option->id }}" @if($option->id ==  old($field->code, $row->{$field->code})) selected @endif>{{ $option->name }}</option>
						
					@else
						
						<option value="{{ $option->id }}" @if($option->id ==  old($field->code, $field->default_value)) selected @endif>{{ $option->name }}</option>
						
					@endisset
				
				@endforeach
			
			</select>
		
		@else
			
			@isset($row)
		
				<input type="text" class="form-control" id="{{ $field->code }}Input" value="{{ $row->{$field->code} }}">
				
			@else
				
				<input type="text" class="form-control" id="{{ $field->code }}Input" value="{{ $field->default_value }}">
				
			@endisset
		
		@endif
		    
	</div>