@props(['title', 'breadcrumbs' => []])
<section class="page-banner" style="background-image:url({{ asset('assets/images/background/bg-banner-1.jpg') }});">
    <div class="top-pattern-layer"></div>

    <div class="banner-inner">
        <div class="auto-container">
            <div class="inner-container clearfix">
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if (!$loop->last)
                            <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                        @else
                            <li>{{ $breadcrumb['title'] }}</li>
                        @endif
                    @endforeach
                </ul>
                <h1>{{ $title }}</h1>
            </div>
        </div>
    </div>
</section>
