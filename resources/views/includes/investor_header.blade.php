  <!-- Main Header-->
            <header class="main-header">
                <div class="header-top">
                    <div class="auto-container">
                        <div class="clearfix">
                            <!--Top Left-->
                            <div class="top-left">
                                <?php $contactus_helper = contactUsHelper(); ?>
                                <ul class="top-links clearfix">
                                    <li>Welcome to TaxPDR</li>
                                    <!--li><span class="fa fa-map-pin"></span>{{ $contactus_helper->mobile }}</li-->
                                    <li><span class="fa fa-envelope-o"></span><a href="mailto:{{ $contactus_helper->email}}"> {{ $contactus_helper->email}}</a></li>
                                </ul>
                            </div>
                            <!--Top Right-->
                            <div class="top-right">
                                <ul class="top-links clearfix">
                                    <li><div class="social-links">
                                        <a href="https://www.facebook.com/taxpdr/" target="_blank" ><span class="fa fa-facebook-f"></span></a>
                                        <a href="https://twitter.com/TaxPDR" target="_blank"><span class="fa fa-twitter"></span></a>
                                        <a href="https://www.linkedin.com/company/taxpdr/" target="_blank"><span class="fa fa-linkedin"></span></a>
                                    </div>
                                </li>
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
                                            <li class="" id="home_li"><a href="{{ route('investor-dashboard') }}">Home</a></li>
                                            <li  id="report_li"><a href="{{ route('investor-reports') }}">My Reports</a></li>
                                            <li  id="checkout_li"><a href="{{ route('investor.newly.added.request')}}">Checkout(<span class="checkout_count">{{ cartItemsCounts(\Auth::user()->id)}}</span>)</a></li>
                                            <li class="dropdown" id="profile_id"><a href="{{ route('myprofile') }}" class="ellipsis">{{ substr(\Auth::user()->name,0,20)}}</a>
                                            <ul>
                                                <li><a href="{{ route('myprofile') }}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
                                                <li><a href="{{route('profile-setting')}}"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
                                                <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>
 Log Out</a></li>
                                            </ul>

                                            </li>
                                           
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