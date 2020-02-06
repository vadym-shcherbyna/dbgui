	
	<div class="input-group mr-3 mb-2">
	
		<div class="input-group-prepend">
			
			<span class="input-group-text">{{ $field->name }}</span>
			
		</div>			
								
		<input type="text" class="form-control item-list-filter-input" data-id="{{ $field->id }}" value="{{ $field->value }}" data-filter="{{ $field->id }}" data-url="{{ $table->code }}">						
		
		<div class="input-group-append">	
			
			<span class="input-group-text cursor-pointer item-list-filter-search" data-input="{{ $field->id }}"  data-filter="{{ $field->id }}" data-url="{{ $table->code }}">
				
				<i class="fas fa-search fa-fw"></i></span>
    
		</div>		

		@isset($field->value)
		
			<div class="input-group-append">	
			
				<span class="input-group-text cursor-pointer item-list-clear" data-filter="{{ $field->id }}"  data-url="{{ $table->code }}">
				
					<i class="fas fa-times-circle fa-fw"></i></span>
    
			</div>		
			
		@endisset		
	
	</div>
