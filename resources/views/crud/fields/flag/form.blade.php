<div class="form-group form-check">

	<input type="hidden" name="{{ $field->code }}" value="0">

    <input type="checkbox" class="form-check-input" id="{{ $field->code }}_input" name="{{ $field->code }}" value="1"
	    @isset($row)
            @if(old($field->code, $row->{$field->code})) checked @endif>
        @else
            @if(old($field->code, $field->default_value)) checked @endif>
        @endisset

    <label class="form-check-label cursor-pointer" for="{{ $field->code }}_input">{{ $field->name }}</label>

</div>
