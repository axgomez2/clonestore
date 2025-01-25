@props(['items' => []])

<div class="page-header mb-3">
    <div class="row align-items-center">
        <div class="col">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel</a></li>
                @foreach($items as $item)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $item['title'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </div>
    </div>
</div>

