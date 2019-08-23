@if (count($breadcrumbs))

    <nav class="breadcrumbs-nav z-depth-0">
        <div class="nav-wrapper">
            <div style="padding: 0 1em">
                <div class="col s12">
                    @foreach ($breadcrumbs as $breadcrumb)

                        @if ($breadcrumb->url && !$loop->last)
                            <a href="{{ $breadcrumb->url }}" class="breadcrumb">{{ $breadcrumb->title }}</a>
                        @else
                            <span class="breadcrumb">{{ $breadcrumb->title }}</span>
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    </nav>

@endif
