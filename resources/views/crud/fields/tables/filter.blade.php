	
	<div class="input-group mr-3 mb-2">
	
		<div class="input-group-prepend">
			
			<span class="input-group-text">{{ $field->name }}</span>
			
		</div>			
								
		<select data-filter="{{ $field->id }}" data-url="{{ $table->code }}" class="form-control item-list-filter-select">
									
			<option value="0"></option>										
			
			@foreach($field->options as $option)
			
				<option value="{{  $option->id }}" @if($field->value  == $option->id) class="text-success" selected @endif>{{ $option->name }}</option>											
			
			@endforeach
									
		</select>		
		
		@isset($field->value)
		
			<div class="input-group-append">	
			
				<span class="input-group-text cursor-pointer item-list-clear" data-filter="{{ $field->id }}"  data-url="{{ $table->code }}">
				
					<i class="fas fa-times-circle fa-fw"></i></span>
    
			</div>		
			
		@endisset
	
	</div>
