@if($items->total()  > 10)
	<small>{{ $items->count() }} @lang('crud.items.list.items_of') {{ $items->total() }}</small>
@else
	<small>@lang('crud.items.list.total_items'): {{ $items->total() }}</small>
@endif