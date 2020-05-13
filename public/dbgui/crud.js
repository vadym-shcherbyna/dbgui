// SET CSRF  for Header
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

// Tooltip init
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
});

// menu collapse
$('.list-group-collapse').on('shown.bs.collapse', function () {
	var chevronId = $(this).data('chevron');
	$('#chevron' + chevronId).removeClass('fa-chevron-right');
	$('#chevron' + chevronId).addClass('fa-chevron-down');
})

$('.list-group-collapse').on('hidden.bs.collapse', function () {
	var chevronId = $(this).data('chevron');
	$('#chevron' + chevronId).removeClass('fa-chevron-down');
	$('#chevron' + chevronId).addClass('fa-chevron-right');
})


// Event for pagination
$("body").on("change", '.item-list-numrows', function(){
	// <select class="form-control item-list-numrows" data-url="{{ $table->code }}">
	var url  = $(this).data('url');
	var value =  $(this).val();

	window.location = '/crud/' + url + '/numrows/' + value;
})	;

// Item list Filters  Events

// Event  for  select' filters
$("body").on("change", '.item-list-filter-select', function(){
	// <select data-filter="{{ $field->id }}" data-url="{{ $table->code }}" class="form-control item-list-filter mr-4">
	var filter  = $(this).data('filter');
	var url  = $(this).data('url');
	var value =  $(this).val();

	window.location = '/crud/' + url + '/filter/' + filter  + '/value/'  + value;
})	;

// Event  for  search' filters
$("body").on("click", '.item-list-filter-search', function(){
	var input  = $(this).data('input');
	var filter  = $(this).data('filter');
	var url  = $(this).data('url');
	var value = $('.item-list-filter-input[data-id="' + input + '"]').val();

	if (value.length > 1) {
		window.location = '/crud/' + url + '/filter/' + filter  + '/value/'  + value;
	}
	else {
		$('.item-list-filter-input[data-id="' + input + '"]').focus();
	}
});

// Event for Enter button
$('.item-list-filter-input').keypress(function(e) {
	if (e.which == '13') {
		var filter  = $(this).data('filter');
		var url  = $(this).data('url');
		var value = $(this).val();

		if (value.length > 1) {
			window.location = '/crud/' + url + '/filter/' + filter  + '/value/'  + value;
		}
	}
});

// Event  for  clear filter
$("body").on("click", '.item-list-clear', function(){
	// <button type="button" class="btn btn-outline-secondary item-list-clear" data-filter="{{ $field->id }}"  data-url="{{ $table->code }}">\
	var filter  = $(this).data('filter');
	var url  = $(this).data('url');

	window.location = '/crud/' + url + '/filter/' + filter  + '/value/clear';
})	;