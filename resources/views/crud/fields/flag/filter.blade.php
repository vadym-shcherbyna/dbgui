	
	<div class="input-group mr-3 mb-2">
	
		<div class="input-group-prepend">
			
			<span class="input-group-text">{{ $field->name }}</span>
			
		</div>			
								
		<select data-filter="{{ $field->id }}" data-url="{{ $table->code }}" class="form-control item-list-filter-select">
			
			<option value="clear"></option>	
			
			<option value="1" @if($field->value == '1') selected @endif>Yes</option>
			
			<option value="0" @if($field->value == '0') selected @endif>No</option>
									
		</select>		
		
		@isset($field->value)
		
			<div class="input-group-append">	
			
				<span class="input-group-text cursor-pointer item-list-clear" data-filter="{{ $field->id }}"  data-url="{{ $table->code }}">
				
					<i class="fas fa-times-circle fa-fw"></i></span>
    
			</div>		
			
		@endisset
	
	</div>
