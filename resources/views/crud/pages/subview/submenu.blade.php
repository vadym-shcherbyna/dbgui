<ul class="nav nav-tabs card-header-tabs">

    <li class="nav-item">
        <a class="nav-link @if($routeName == 'items.list') active @endif" href="{{route('items.list', $table->code)}}">
            <i class="fas fa-list fa-fw mr-2"></i>
            @if($table->flag_system)
                @lang('crud.menu.'.$table->code)
            @else
                {{$table->name}}
            @endif
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if($routeName == 'items.add') active @endif" href="{{route('items.add', $table->code)}}">
            <i class="fas fa-plus-square fa-fw mr-2"></i>
            @lang('crud.add')
            {{ $table->item_name }}
        </a>
    </li>

    @if($routeName == 'items.edit')
        <li class="nav-item">
            <a class="nav-link active" href="{{route('items.edit', [$table->code, $item->id])}}">
                <i class="fas fa-edit fa-fw mr-2"></i>
                @lang('crud.edit')
                {{ $table->item_name }}
            </a>
        </li>
    @endif

</ul>