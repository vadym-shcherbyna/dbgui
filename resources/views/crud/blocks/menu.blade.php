				
	@foreach($table_groups as $group)

		<div class="list-group mb-2 bg-light">
					
			<a href="javascript: return void(0);" class="list-group-item list-group-item-action" data-toggle="collapse" data-target="#menu{{ $group->id }}">
		
				<span class="text-info">{{ $group->name }}</span></a>		
		
		</div>
				
		@isset($group->tables)		
				
			<div class="list-group collapse mb-2  @if($table->table_group_id == $group->id) show @endif" id="menu{{ $group->id }}">
				
				@foreach($group->tables as $tableMenu)
				
					<a href="{{ env('APP_URL') }}/crud/{{ $tableMenu->url }}/list" class="list-group-item list-group-item-action @if($table->code == $tableMenu->code) bg-light @endif">
					
						<i class="fas fa-{{ $tableMenu->fa }} fa-fw mr-2"></i> {{ $tableMenu->name }}</a>
					
				@endforeach
  
			</div>	
			
		@endisset
		
	@endforeach