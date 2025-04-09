<!--header start-->
<header id="masthead" class="header ttm-header-style-06">

    <!-- ttm-header-wrap -->
    <div class="ttm-header-wrap">
        <!-- ttm-stickable-header-w -->
        <div id="ttm-stickable-header-w" class="ttm-stickable-header-w ttm-bgcolor-darkgrey clearfix">
            {{--header info slider--}}

            <div id="site-header-menu" class="site-header-menu">
                <div class="site-header-menu-inner ttm-stickable-header">
                    <div class="container">
                        <!-- site-branding -->
                        <div class="site-branding">
                        <a class="home-link" href="{{route('home')}}" title="Fondex" rel="home">
                                @if(Request::is('/'))
                                <img id="logo-img" class="img-center" src="{{ URL::asset('user/images/coco_logo.png') }}" alt="logo-img">
                                @else
                                <img id="logo-img" class="img-center" src="{{ URL::asset('user/images/logo_nav_white.png') }}" alt="logo-img">
                                @endif
                            </a>
                        </div><!-- site-branding end -->
                        <!--site-navigation -->
                        <div id="site-navigation" class="site-navigation">
                            {{--<div class="header-btn">
                                <a href="contact.html" class="ttm-btn ttm-btn-size-sm ttm-btn-bgcolor-skincolor"> Request for quote</a>
                            </div>--}}
                           {{-- <div class="ttm-rt-contact">
                                <!-- header-icons -->
                                <div class="ttm-header-icons ">
                                        <span class="ttm-header-icon ttm-header-cart-link">
                                            <a href="#"><i class="fa fa-shopping-cart"></i>
                                                <span class="number-cart">0</span>
                                            </a>
                                        </span>
                                    <div class="ttm-header-icon ttm-header-search-link">
                                        <a href="#" class="sclose"><i class="ti ti-search"></i></a>
                                        <div class="ttm-search-overlay">
                                            <div class="ttm-bg-layer"></div>
                                            <div class="ttm-icon-close"></div>
                                            <div class="ttm-search-outer">
                                                <form method="get" class="ttm-site-searchform" action="#">
                                                    <input type="search" class="field searchform-s" name="s" placeholder="Type Word Then Enter...">
                                                    <button type="submit">
                                                        <i class="ti ti-search"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- header-icons end -->
                            </div>--}}
                            <div class="ttm-menu-toggle">
                                <input type="checkbox" id="menu-toggle-form">
                                <label for="menu-toggle-form" class="ttm-menu-toggle-block">
                                    <span class="toggle-block toggle-blocks-1"></span>
                                    <span class="toggle-block toggle-blocks-2"></span>
                                    <span class="toggle-block toggle-blocks-3"></span>
                                </label>
                            </div>
                            <nav id="menu" class="menu">
                                <ul class="dropdown">
                                    <li><a href="{{route('home')}}">Accueil</a></li>
                                    <li><a href="{{route('shop')}}">Boutique</a></li>
                                    <li><a href="{{route('about-us')}}">Elixir Coco</a></li>
                                    <li><a href="{{route('contact')}}">Contactez-nous</a></li>
                                </ul>
                            </nav>
                        </div><!-- site-navigation end-->
                    </div>
                </div>
            </div>
        </div><!-- ttm-stickable-header-w end-->
    </div><!--ttm-header-wrap end -->
</header>
<!--header end-->
