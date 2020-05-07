@if($items->total()  > 10)
    <select class="form-control item-list-numrows" data-url="{{ $table->code }}">
        @foreach($paginationArray as $pagination)
            <option value="{{ $pagination }}" @if($currentPagination == $pagination) selected @endif>{{ $pagination }}</option>
        @endforeach
    </select>
@endif