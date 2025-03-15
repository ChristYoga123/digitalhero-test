<header class="main-header header-style-one">
    <div class="header-container">
        <!--Header Background Shape-->
        <div class="bg-shape-box">
            <div class="bg-shape"></div>
        </div>

        <!-- Header Top -->
        <div class="header-top">
            <div class="inner clearfix">
                <div class="top-left">
                    <div class="top-text">Welcome to Digital Hero Gaming Rental</div>
                </div>

                <div class="top-right">
                    <ul class="info clearfix">
                        <li><a href="tel:666-888-0000">666 888 0000</a></li>
                        <li><a href="mailto:needhelp@sintix.com">needhelp@sintix.com</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="inner-container clearfix">
                <!--Logo-->
                <div class="logo-box">
                    <div class="logo"><a href="{{ route('index') }}"
                            title="Sintix - Digital Video Gaming and Consol HTML Template"><img
                                src="{{ asset('assets/images/logo.png') }}"
                                alt="Sintix - Digital Video Gaming and Consol HTML Template"
                                title="Sintix - Digital Video Gaming and Consol HTML Template"></a></div>
                </div>

                <!--Nav Box-->
                <div class="nav-outer clearfix">
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler"><span class="icon flaticon-menu-2"></span></div>

                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                @foreach ($menus as $menu)
                                    <li><a href="{{ url($menu['url']) }}">{{ $menu['title'] }}</a></li>
                                @endforeach
                                <li>
                                    <a href="" class="btn style-one">Login</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Menu End-->

                    <ul class="social-links clearfix">
                        <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                        <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                        <li><a href="#"><span class="fab fa-linkedin-in"></span></a></li>
                        <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                    </ul>

                </div>
            </div>
        </div>
        <!--End Header Upper-->
    </div><!--End Header Container-->

    <!-- Sticky Header  -->
    <div class="sticky-header">
        <div class="auto-container clearfix">
            <!--Logo-->
            <div class="logo pull-left">
                <a href="index.html" title=""><img src="{{ asset('assets/images/sticky-logo.png') }}"
                        alt="" title=""></a>
            </div>
            <!--Right Col-->
            <div class="pull-right">
                <!-- Main Menu -->
                <nav class="main-menu clearfix">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </nav><!-- Main Menu End-->
            </div>
        </div>
    </div><!-- End Sticky Menu -->

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><span class="icon flaticon-cancel"></span></div>

        <nav class="menu-box">
            <div class="nav-logo"><a href="{{ route('index') }}"><img src="{{ asset('assets/images/logo.png') }}"
                        alt="" title=""></a></div>
            <div class="menu-outer">
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            </div>
            <!--Social Links-->
            <div class="social-links">
                <ul class="clearfix">
                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                    <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                </ul>
            </div>
        </nav>
    </div><!-- End Mobile Menu -->
</header>
