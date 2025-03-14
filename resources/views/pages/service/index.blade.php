@extends('layouts.front')

@section('content')
    <section class="page-banner" style="background-image:url(assets/images/background/bg-banner-1.jpg);">
        <div class="top-pattern-layer"></div>

        <div class="banner-inner">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <ul class="bread-crumb clearfix">
                        <li><a href="index.html">Home</a></li>
                        <li>Games</li>
                    </ul>
                    <h1>Games</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="games-section games-page-section">

        <div class="auto-container">

            <div class="row clearfix">
                <!--Game Block-->
                @foreach ($services as $service)
                    @ServiceCard(['service' => $service])
                @endforeach
            </div>
            {{ $services->links() }}
        </div>

    </section>
@endsection
