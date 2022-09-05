<style>
    div.experiment_unit_section_scroll {
        /* height: 310px; */
        overflow-y: auto;
        min-height: 50px;
        max-height: 310px;
    }

    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: #808080;
        color: white;
        cursor: pointer;
        padding: 10px;
        border-radius: 40px;
    }

    #myBtn:hover {
        background-color: #555;
    }
</style>

<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    @php
    $user = App\Models\Organization\Users\User::find(Auth::user()->id);
    $notification_count = $user->unreadNotifications->count();
    @endphp
    <div class="navbar-content">
        @php $tenants = getTenent() @endphp
        @if(!empty($tenants['account_details']['organization_logo']))
        <img class="" src="{{ asset($tenants['account_details']['organization_logo']) }}" alt="" width="13%;" height="33px" style="margin-top:13px">
        @endif
        <ul class="navbar-nav">
            <li class="nav-item">
                <form class="search-form">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="navbarForm" placeholder="Search here..." style="width: 350px;">
                    </div>
                </form>
            </li>
            <li class="nav-item  nav-profile">
                Hi, @if (Auth::user()){{Auth::user()->first_name}} {{Auth::user()->last_name}}@endif
            </li>
            <li class="nav-item dropdown nav-notifications">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    @if($notification_count!=0)
                    <div class="indicator">
                        <div class="circle"></div>
                    </div>
                    @endif
                </a>

                <div class="dropdown-menu " aria-labelledby="notificationDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">

                        <p class="mb-0 font-weight-medium">{{$notification_count}} New Notifications</p>
                        @if($notification_count!=0)
                        <a href="javascript:void(0)" data-url="{{url('/clear-all-notification')}}" data-method="GET" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to Read All Notification?" class="text-muted">Read all</a>
                        @endif
                    </div>
                    @if($notification_count!=0)
                    <div class="dropdown-body experiment_unit_section_scroll">
                        @foreach ($user->unreadNotifications->take(5) as $notification)

                        <a href="javascript:;" class="dropdown-item">
                            <div class="icon">
                                <!-- <i data-feather="{{!empty($activity->user_menu->menu_icon) ? $activity->user_menu->menu_icon:''}}"></i> -->
                            </div>
                            <div class="content">
                                <p class="text-secondary"><strong>{{$notification->data['data']['msg']}}</p>
                                <p class="sub-text text-muted ">{{___ago($notification->created_at)}}</p>
                            </div>
                        </a>
                        @endforeach

                    </div>
                    @endif
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="{{ url('/notification') }}">View all</a>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown nav-profile" style="margin: 12px;">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ url(!empty(Auth::user()->profile_image)?Auth::user()->profile_image:url('assets/images/user_icon.png')) }}" alt="profile">
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{ url(!empty(Auth::user()->profile_image) ? Auth::user()->profile_image:url('assets/images/user_icon.png')) }}" alt="profile">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0"> @if (Auth::user()){{Auth::user()->first_name}} {{Auth::user()->last_name}}@endif</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <li class="nav-item">
                                <a href="{{ url('/organization/profile') }}" class="nav-link">
                                    <i data-feather="user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            @if(Auth::user()->role=='console_admin')
                            <li class="nav-item">
                                <a href="{{ url('/organization/settings') }}" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                            @endif
                            <!-- <li class="nav-item">
                                <a href="{{ url('/organization/settings') }}" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>Support</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>Release Notes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link">
                                    <i data-feather="settings"></i>
                                    <span>Version</span>
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
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-chevron-up"></i></button>

<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
