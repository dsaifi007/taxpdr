
 <div class="page-header">
        <div class="leftside-header">
            <div class="logo">
                @if(\Auth::check())
                <a href="{{route('admin.dashboard')}}" class="on-click">
                    <img alt="logo" src="{{asset('images/logo.png')}}" />
                </a>
                @else
                 <a href="{{route('admin.adminlogin')}}" class="on-click">
                    <img alt="logo" src="{{asset('images/logo.png')}}" />
                </a>
                @endif
            </div>
            <div id="menu-toggle" class="visible-xs toggle-left-sidebar" data-toggle-class="left-sidebar-open" data-target="html">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="rightside-header">
            <div class="header-middle"></div>
            <div class="header-section hidden-xs" id="notice-headerbox">
            </div>
            <div class="header-section" id="user-headerbox">
                <div class="user-header-wrap">
                    <!--<div class="user-photo">
                        <img src="images/user-avatar.jpg" alt="Jane Doe" />
                    </div>-->
                    <div class="user-info">
                        <span class="user-name">{{ \Auth::user()->name }}</span>
                       
                    </div>
                    <i class="fa fa-plus icon-open" aria-hidden="true"></i>
                    <i class="fa fa-minus icon-close" aria-hidden="true"></i>
                </div>
                <div class="user-options dropdown-box">
                    <div class="drop-content basic">
                        <ul>
                            <li> <a href="{{ route('admin.change.password')}}"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a></li>
                            <li><a href="{{ route('admin.logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </div>