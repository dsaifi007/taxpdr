 <!--Main Footer-->
<footer class="main-footer">
                <!--Footer Bottom-->
                <div class="footer-bottom">
                    <div class="auto-container">
                        <div class="row clearfix">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="copyright">&copy;  2018 Tax PDR</div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="footer-nav clearfix">
                                    <ul class="clearfix">
                                        <li>
                                            <?php $routeName = Route::currentRouteName(); ?>
                                            @if($routeName == 'home-new')
                                            <a href="{{url('#top-header')}}">Home</a>
                                            @else
                                            <a href="{{url('/')}}">Home</a>
                                            @endif
                                        </li>
                                         @if(\Auth::check())
                                      
                                        @else
                                             <li>
                                            @if($routeName == 'home-new')
                                            <a href="#about-us">About</a>
                                            @else
                                            <a href="{{url('/#about-us')}}">About</a>
                                            @endif
                                           </li>
                                        @endif
                                        <li><a href="{{ route('policy')}}">Policy</a></li>
                                        <li><a href="{{ route('showterms')}}">Terms</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
    <!--End Footer-->
    <div class="scroll-to-top scroll-to-target" data-target=".main-header"><span class="fa fa-long-arrow-up"></span></div>