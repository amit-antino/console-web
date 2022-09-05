<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{url(!empty(Auth::user()->profile_image)?Auth::user()->profile_image:url('assets/images/user_icon.png'))}}" alt="profile">
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{url(!empty(Auth::user()->profile_image)?Auth::user()->profile_image:url('assets/images/user_icon.png'))}}" alt="profile">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0"> @if (Auth::user()){{Auth::user()->first_name}} {{Auth::user()->last_name}}@endif</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <li class="nav-item">
                                <a href="{{ url('/admin/user/profile') }}" class="nav-link">
                                    <i data-feather="user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="{{ url('/admin/master/settings') }}" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>Settings</span>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link" data-toggle="modal" data-target="#modal_logout">
                                    <i data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>