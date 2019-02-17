@extends('layouts.app')

@section('content')
 <!--Main Slider-->
    <section class="main-slider" id="banner" data-start-height="920" data-slide-overlay="yes">
                <div class="tp-banner-container">
                    <div class="tp-banner">
                        <ul>
                            <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="{{ asset('images/main-slider/image-2.jpg')}}"  data-saveperformance="off"  data-title="Awesome Title Here">
                                <img src="{{ asset('images/main-slider/image-2.jpg')}}"  alt=""  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat"> 
                                <div class="tp-caption sfl sfb tp-resizeme"
                                    data-x="left" data-hoffset="15"
                                    data-y="center" data-voffset="-100"
                                    data-speed="1500"
                                    data-start="0"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn">
                                    <h2 style="font-size: 38px;">
                                    With Correct depreciation </br> schedule,maximise your</br>  property returns.</h2>
                                </div>
                                <div class="tp-caption sfl sfb tp-resizeme"
                                    data-x="left" data-hoffset="15"
                                    data-y="center" data-voffset="30"
                                    data-speed="1500"
                                    data-start="500"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn">
                                    <div class="text" style="font-size:18px;">Now you can find out the exact Cash Return on your Investment Property</div>
                                </div>
                                <div class="tp-caption sfl sfb tp-resizeme"
                                    data-x="left" data-hoffset="15"
                                    data-y="center" data-voffset="140"
                                    data-speed="1500"
                                    data-start="1000"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn"><a href="#now-availble" class="theme-btn btn-style-one"><span class="icon icon-left lnr lnr-download"></span> Download Our App</a></div>
                                <div class="tp-caption sfr sfb tp-resizeme"
                                    data-x="right" data-hoffset="-10"
                                    data-y="bottom" data-voffset="50"
                                    data-speed="1500"
                                    data-start="1500"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn">
                                    <figure class="image"><img src="{{ asset('images/main-slider/content-image-2.png')}}" alt=""></figure>
                                </div>
                            </li>
                            <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="{{ asset('images/main-slider/image-1.jpg')}}"  data-saveperformance="off"  data-title="Awesome Title Here">
                                <img src="{{ asset('images/main-slider/image-1.jpg')}}"  alt=""  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat"> 
                                <div class="tp-caption sfl sfb tp-resizeme"
                                    data-x="left" data-hoffset="15"
                                    data-y="center" data-voffset="-100"
                                    data-speed="1500"
                                    data-start="0"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn">
                                    <h2 style="font-size: 38px;">Know your more accurate</br> Property depreciation schedules <br /> with us</h2>
                                </div>
                                <div class="tp-caption sfl sfb tp-resizeme"
                                    data-x="left" data-hoffset="15"
                                    data-y="center" data-voffset="30"
                                    data-speed="1500"
                                    data-start="500"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn">
                                    <div class="text" style="font-size:18px;">TaxPDR helps you to get the best option possible in Tax<br> Depreciation for your Residential Property.</div>
                                </div>
                                <!--<div class="tp-caption sfl sfb tp-resizeme"-->
                                <!--    data-x="left" data-hoffset="15"-->
                                <!--    data-y="center" data-voffset="140"-->
                                <!--    data-speed="1500"-->
                                <!--    data-start="1000"-->
                                <!--    data-easing="easeOutExpo"-->
                                <!--    data-splitin="none"-->
                                <!--    data-splitout="none"-->
                                <!--    data-elementdelay="0.01"-->
                                <!--    data-endelementdelay="0.3"-->
                                <!--    data-endspeed="1200"-->
                                <!--    data-endeasing="Power4.easeIn"><a href="#" class="theme-btn btn-style-one"><span class="icon icon-left lnr lnr-screen"></span> Visit</a></div>-->
                                <div class="tp-caption sfr sfb tp-resizeme"
                                    data-x="right" data-hoffset="8"
                                    data-y="center" data-voffset="80"
                                    data-speed="1500"
                                    data-start="1500"
                                    data-easing="easeOutExpo"
                                    data-splitin="none"
                                    data-splitout="none"
                                    data-elementdelay="0.01"
                                    data-endelementdelay="0.3"
                                    data-endspeed="1200"
                                    data-endeasing="Power4.easeIn">
                                    <figure class="image"><img src="{{ asset('images/main-slider/content-image-1.png')}}" alt=""></figure>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!--End Main Slider-->
            <!--What We Offer--->
            <section id="about-us" class="what-we-offer">
                <div class="auto-container">
                    <!--Title-->
                    <div class="sec-title centered">
                        <h2>About T<span>ax</span>PDR</h2>
                        <div class="desc-text" style="margin-bottom: 15px;">Our Quality speaks for Our Work!</div>
                        <p class="text">TaxPDR is a company that offers the best Tax Depreciation Services in the market for properties including Investment, Commercial, and Residential Properties. Our team prepares excellent Depreciation Schedules to help our clients claim their right property depreciation deductions.</p>
                        <p class="text">TaxPDR also offers its services to Property Investors, Real Estate Professionals, Accountants and Property Developers as well.</p>
                    </div>
                </div>
            </section>
            <!--Features Section--->
            <section class="features-section-one" id="features-section">
                <div class="auto-container">
                    <!--Title-->
                    <div class="sec-title centered">
                        <h2>Features of T<span>ax</span>PDR</h2>
                    </div>
                    <div class="row clearfix">
                        <!--Column-->
                        <div class="column pull-left col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <!--Info BLock-->
                            <div class="info-block-two wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="icon-box"><span class="ti-bell"></span></div>
                                    <h3>Single or Multiple Requests</h3>
                                    <div class="text">Now you can request single or multiple properties depreciation schedule in one go.</div>
                                </div>
                            </div>
                            <!--Info BLock-->
                            <div class="info-block-two wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="icon-box"><span class="ti-bar-chart"></span></div>
                                    <h3>Status Tracking</h3>
                                    <div class="text">You can track progress of your requested schedules online.</div>
                                </div>
                            </div>
                         
                        </div>
                        <!--Column-->
                        <div class="column pull-right col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <!--Info BLock-->
                            <div class="info-block-three wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <!--<div class="inner-box">
                                    <div class="icon-box"><span class="ti-ruler-alt"></span></div>
                                    <h3>Tax Calculator</h3>
                                    <div class="text">The user can easily calculate his/her Tax Depreciation Estimate with TaxPDR calculator.</div>
                                </div>-->
                            </div>
                            <!--Info BLock-->
                            <div class="info-block-three wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="icon-box"><span class="ti-vector"></span></div>
                                    <h3>Certification</h3>
                                    <div class="text">The reports evaluated by TaxPDR are certified as by professional accountants.</div>
                                </div>
                            </div>
                            <!--Info BLock-->
                            <div class="info-block-three wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    <div class="icon-box"><span class="ti-lock"></span></div>
                                    <h3>Mobile Apps</h3>
                                    <div class="text">The TaxPDR Android and iOS apps are available in Google’s Play store and Apple iTunes stores for more efficiency. </div>
                                </div>
                            </div>
                        </div>
                        <!--Image Column-->
                        <div class="image-column col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <figure class="image-box wow slideInUp" data-wow-delay="0ms" data-wow-duration="1500ms"><img src="{{ asset('images/resource/featured-image-1.png')}}" alt=""></figure>
                        </div>
                    </div>
                </div>
            </section>
            <!--Fullwidth Section One-->
            <section class="fullwidth-section-one">
                <div class="outer clearfix">
                    <!--Image Column-->
                    <div class="image-column" style="background-image:url({{ asset('images/background/fluid-image-1.jpg')}});">
                        <figure class="image"><img src="{{ asset('images/resource/fluid-image-1.jpg')}}" alt=""></figure>
                    </div>
                    <!--Content Column-->
                    <div class="content-column">
                        <div class="clearfix">
                            <div class="content-box">
                                <div class="sec-title">
                                    <h2>As an <span style="color:#1A9BD7;">Investor</span></h2>
                                </div>
                                <div class="text-content" style="margin-bottom: 30px;">
                                    <p>With TaxPDR’s Property Depreciation Schedule, investor can maximise the return on their investment by understanding their depreciated claimable amount.</p>
                                    <p>By using the TaxPDR Property Depreciation report service, the investor will be able to get an estimate of their expected Property depreciation amount with few easy steps.</p>
                                </div>
                                <div class="sec-title">
                                    <h2>As a <span style="color:#1A9BD7;">Property agent</span></h2>
                                </div>
                                <div class="text-content">
                                    <p>Request investment property depreciation report on behalf of your clients.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Fullwidth Section Two-->
            <section class="fullwidth-section-two" id="how-it-works">
                <div class="outer clearfix">
                    <!--Image Column-->
                    <div class="image-column" style="background-image:url({{ asset('images/background/fluid-image-2.jpg')}});">
                        <figure class="image"><img src="{{ asset('images/resource/fluid-image-2.jpg')}}" alt=""></figure>
                    </div>
                    <!--Content Column-->
                    <div class="content-column">
                        <div class="clearfix">
                            <div class="content-box">
                                <div class="sec-title">
                                    <h2>As a <span style="color:#1A9BD7;">Surveyor</span></h2>
                                </div>
                                <div class="text-content" style="margin-bottom: 30px;">
                                    <p style="font-size: 16px; line-height: 20px;">As a professional Surveyor you will be able to connect with our hundreds of investors listed across the country to help them with their property depreciation reports.</p>
                                </div>
                                <div class="sec-title">
                                    <h2>As an <span style="color:#1A9BD7;">Accountant</span></h2>
                                </div>
                                <div class="text-content">
                                    <p style="font-size: 16px; line-height: 20px;">Proactively work with investors and surveyors to prepare property’s depreciation report for the investment properties.</p>
                                    <p style="font-size: 16px; line-height: 20px;">Connect with hundreds of investors listed across the country to help them with their property depreciation reports.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--App Screens One-->
            <section class="app-screenshots-one" id="screenshots-section">
                <div class="auto-container">
                    <!--Title-->
                    <div class="sec-title centered">
                        <h2>App ScreenShots</h2>
                        <div class="desc-text">Our App is designed to ensure that users have seamless experience with ease of use. Allowing users the ability to create and manage their accounts online with simple steps.</div>
                    </div>
                    <div class="carousel-outer">
                        <!--Carousel-->
                        <div class="single-item-carousel owl-carousel owl-theme">
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/1.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/2.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/3.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/4.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/5.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/6.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/7.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/8.png')}}" alt=""></figure>
                            </div>
                            <!--Slide-->
                            <div class="slide">
                                <figure class="image"><img src="{{ asset('images/resource/9.png')}}" alt=""></figure>
                            </div>
                        </div>
                        <!--Mockup Layer-->
                        <div class="mockup-layer"></div>
                    </div>
                </div>
            </section>
            <!--Call TO Action-->
            <section class="call-to-action" id="now-availble" style="background-image:url({{ asset('images/background/1.jpg')}});">
                <div class="auto-container">
                    <!--Title-->
                    <div class="sec-title light centered">
                        <h2>NOW AVAILABLE ON</h2>
                    </div>
                    <div class="download-links clearfix">
                        <a href="#" class="link wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms"><img src="{{ asset('images/resource/apple-store-icon.png')}}" alt=""></a>
                        <a href="https://play.google.com/store/apps/details?id=com.taxpdr" class="link wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms"><img src="{{ asset('images/resource/playstore-icon.png')}}" alt=""></a>
                    </div>
                </div>
            </section>
@endsection
<!-- include page js script - - - -->

@section('java-script')
<script type="text/javascript">

$("#signin_li").removeClass("current");
$("#signup_li").removeClass("current");
$("#home_li").addClass("current");

</script>

@endsection