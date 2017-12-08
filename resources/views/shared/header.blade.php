    <!-- Main navbar -->
    <div class="navbar navbar-default header-highlight">

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <a class="navbar-brand" href="/"><img src="{{asset('assets/images/icons/logo.png')}}" alt=""></a>
            <!-- Search -->
            <div class="box">
                <div class="container-1">
                    <span calss="icon" id="search_icon"><a href=""><i class="fa fa-search"></i></a></span>
                    <input type="search" id="search" placeholder="Search..." name="searchStr"/>
                </div>
            </div>
            <!-- Search End -->
            <ul class="nav navbar-nav">
                <!-- <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li> -->
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-setting">
                    <a href="/uploader">
                        <h5>upload.</h5>
                    </a>
                </li>
                <li class="dropdown dropdown-setting">
                    <a href="/">
                        <h5>HD box.</h5>
                    </a>
                </li>

                <li class="dropdown dropdown-setting">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <h5>messages</h5>
                    </a>
                </li>

                <li class="dropdown dropdown-setting">
                    <a href="/setting">
                        <h5>settings.</h5>
                    </a>
                </li>

                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img class="lazy" src="{{asset('assets/images/profile/').'/'.Auth::user()['avatar']}}" alt="" class="setting-avatar">
                        <img class="lazy" src="{{asset('assets/images/icons/icon_settings.png')}}" alt="" class="setting-gear">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="divider"></li>
                        <li class="filtered">
                            <a href="#"> filtered.</a>
                        </li>
                        <li><a href=""> signed.</a></li>
                        <li><a href="/trash"> recently trashed</a></li>
                        <li><a href="{{ url('logout')}}"><i class="icon-switch2"></i> sign out.</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
