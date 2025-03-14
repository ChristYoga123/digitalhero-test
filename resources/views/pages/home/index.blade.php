@extends('layouts.front')

@section('content')
    <!-- Banner Section -->
    <section class="banner-section">
        <div class="banner-carousel owl-theme owl-carousel">
            <!-- Slide Item -->
            <div class="slide-item">
                <div class="image-layer" style="background-image:url(assets/images/main-slider/1.jpg)"></div>

                <div class="auto-container">
                    <div class="content-box">
                        <div class="content">
                            <h2>Selamat Datang di Digital Gaming Rental</h2>
                            <div class="link-box"><a href="games.html" class="theme-btn btn-style-one"><span
                                        class="btn-title">Our Service</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!--Games Section-->
    <section class="games-section">
        <div class="top-pattern-layer"></div>
        <div class="bottom-pattern-layer"></div>

        <div class="auto-container">
            <!--Title-->
            <div class="sec-title centered">
                <h2>Servis Terbaru</h2><span class="bottom-curve"></span>
            </div>

            <div class="row clearfix">
                <!--Game Block-->
                @foreach ($services as $service)
                    @ServiceCard(['service' => $service])
                @endforeach
            </div>
        </div>

    </section>
@endsection
