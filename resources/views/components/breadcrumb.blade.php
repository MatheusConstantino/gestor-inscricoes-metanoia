@props(['items'])

<ol class="breadcrumb float-sm-right">
    @foreach ($items as $item)
        @if ($loop->last)
            <li class="breadcrumb-item active">{{ $item['name'] }}</li>
        @else
            <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
        @endif
    @endforeach
</ol>
