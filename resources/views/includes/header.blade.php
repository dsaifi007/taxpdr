  <!-- Main Header-->
            <header id="top-header" class="main-header">
                <div class="header-top">
                    <div class="auto-container">
                        <div class="clearfix">
                            <!--Top Left-->
                            <div class="top-left">
                                <?php $contactus_helper = contactUsHelper(); ?>
                                <ul class="top-links clearfix">
                                    <li>Welcome to TaxPDR</li>
                                    <!--li><span class="fa fa-map-pin"></span>{{ $contactus_helper->mobile }}</li-->
                                    <li><span class="fa fa-envelope-o"></span> <a href="mailto:{{ $contactus_helper->email}}">{{ $contactus_helper->email}}</a></li>
                                </ul>
                            </div>
                            <!--Top Right-->
                            <div class="top-right">
                                <ul class="top-links clearfix">
                                    <li>
                                        <div class="social-links">
                                        <a href="https://www.facebook.com/taxpdr/" target="_blank" ><span class="fa fa-facebook-f"></span></a>
                                        <a href="https://twitter.com/TaxPDR" target="_blank"><span class="fa fa-twitter"></span></a>
                                        <a href="https://www.linkedin.com/company/taxpdr/" target="_blank"><span class="fa fa-linkedin"></span></a>
                                    </div>
                                </li>
                                    <li><a href="{{ route('login') }}" class="login-link">Request a Quote</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- Main Box -->
                <div class="main-box">
                    <div class="auto-container">
                        <div class="outer-container clearfix">
                            <!--Logo Box-->
                            <div class="logo-box">
                                <div class="logo"><a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Tax Pdr logo"></a></div>
                            </div>
                            <!--Nav Outer-->
                            <div class="nav-outer clearfix">
                                <!-- Main Menu -->
                                <nav class="main-menu">
                                    <div class="navbar-header">
                                        <!-- Toggle Button -->      
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="navbar-collapse collapse scroll-nav clearfix">
                                        <ul class="navigation clearfix">
                                            <!--<li class="" id="home_li"><a href="{{ url('/') }}">Home</a></li>-->
                                            <?php $routeName = Route::currentRouteName(); ?>
                                            <li id="home_li">
                                                @if($routeName == 'home-new')
                                                         <a href="{{url('#top-header')}}" id="home_a">Home</a>
                                                @else
                                            <a href="{{url('/')}}" id="home_a">Home</a>
                                            @endif
                                            </li>
                                            <li id="features-section_li" ><a href="{{ url('/#features-section')}}" id="features-section_a">Features</a></li>
                                            <li id="how-it-works_li"><a href="{{ url('/#how-it-works')}}" id="how-it-works_a">How It Works</a></li>
                                            <li id="screenshots-section_li" ><a href="{{ url('/#screenshots-section')}}"  id="screenshots-section_a">App Screenshots</a></li>
                                            <li id="signin_li"><a href="{{ route('login') }}">Sign In</a></li>
                                            <li id="signup_li"><a href="{{ route('register') }}">Sign Up</a></li>
                                            
                                        </ul>
                                    </div>
                                </nav>
                                <!-- Main Menu End-->
                            </div>
                            <!--Nav Outer End-->
                        </div>
                    </div>
                </div>
            </header>
            <!--End Main Header -->