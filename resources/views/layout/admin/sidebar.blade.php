<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <img class="img-fluid" src="{{ asset('/assets/images/logo.png') }}" alt="" width="150px;">
        </a>
        <div class="sidebar-toggler @if(!empty($get_cookie_value)) {{$get_cookie_value}} @else not-active @endif ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ active_class(['admin/dashboard']) }}{{ active_class(['/admin/dashboard']) }}">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['admin/tenant']) }}{{ active_class(['admin/tenant/*']) }}">
                <a href="{{ url('/admin/tenant') }}" class="nav-link">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Tenants</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['admin/log']) }}{{ active_class(['admin/log/*']) }}">
                <a href="{{ url('/admin/log') }}" class="nav-link">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Activity Logs</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['admin/admin_users']) }}{{ active_class(['admin/admin_users/*']) }}">
                <a href="{{ url('/admin/admin_users') }}" class="nav-link">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Admin Users</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['admin/ticket']) }}{{ active_class(['/admin/ticket/*']) }}">
                <a href="{{ url('admin/ticket') }}" class="nav-link">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Reported Issues</span>
                </a>
            </li>
            <li class="nav-item nav-category">Master</li>
            <li class="nav-item {{ active_class(['admin/master/unit_type']) }}{{ active_class(['/admin/master/unit_type']) }}">
                <a href="{{ url('/admin/master/unit_type') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Unit System</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/currency']) }}{{ active_class(['/admin/master/currency']) }}">
                <a href="{{ url('/admin/master/currency') }}" class="nav-link">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Currency System</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['admin/master/tenant/*']) }}">
                <a class="nav-link" data-toggle="collapse" href="#admin" role="button" aria-expanded="{{ is_active_route(['admin/master/tenant/*']) }}" aria-controls="admin">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Tenants</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ show_class(['admin/master/tenant/*']) }}" id="admin">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/tenant/organization_type') }}" class="nav-link {{ active_class(['admin/master/tenant/organization_type'])}}{{ active_class(['admin/master/tenant/organization_type/*'])}}">Organization Type</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/tenant/plan') }}" class="nav-link {{ active_class(['admin/master/tenant/plan'])}}{{ active_class(['admin/master/tenant/plan/*'])}}">Plan</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ active_class(['admin/master/chemical/*']) }}">
                <a class="nav-link" data-toggle="collapse" href="#chemical" role="button" aria-expanded="{{ is_active_route(['admin/master/chemical/*']) }}" aria-controls="chemical">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Products</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ show_class(['admin/master/chemical/*']) }}" id="chemical">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/category') }}" class="nav-link {{ active_class(['admin/master/chemical/category']) }}{{ active_class(['admin/master/chemical/category/*'])}}">Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/classification') }}" class="nav-link {{ active_class(['admin/master/chemical/classification']) }}{{ active_class(['admin/master/chemical/classification/*'])}}">Classification</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/property') }}" class="nav-link {{ active_class(['admin/master/chemical/property']) }}{{ active_class(['admin/master/chemical/property/*'])}}">Property</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/sub_property') }}" class="nav-link {{ active_class(['admin/master/chemical/sub_property']) }}{{ active_class(['admin/master/chemical/sub_property/*'])}}">Sub Property</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/hazard_class') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/hazard_class']) }}{{ active_class(['admin/master/chemical/hazard/hazard_class/*'])}}">Hazard Class</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/hazard_pictogram') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/hazard_pictogram']) }}{{ active_class(['admin/master/chemical/hazard/hazard_pictogram/*'])}}">Hazard Pictogram</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/code_type') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/code_type']) }}{{ active_class(['admin/master/chemical/hazard/code_type/*'])}}">Code Type</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/code_sub_type') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/code_sub_type']) }}{{ active_class(['admin/master/chemical/hazard/code_sub_type/*'])}}">Code Sub Type</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/code_statement') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/code_statement']) }}{{ active_class(['admin/master/chemical/hazard/code_statement/*'])}}">Code Statement</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/category') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/category']) }}{{ active_class(['admin/master/chemical/hazard/category/*'])}}">Hazard Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/chemical/hazard/hazard') }}" class="nav-link {{ active_class(['admin/master/chemical/hazard/hazard']) }}{{ active_class(['admin/master/chemical/hazard/hazard/*'])}}">Hazard Statement</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ active_class(['admin/master/process_simulation/*']) }}">
                <a class="nav-link" data-toggle="collapse" href="#process_simulation" role="button" aria-expanded="{{ is_active_route(['admin/master/process_simulation/*']) }}" aria-controls="process_simulation">
                    <i class="link-icon" data-feather="target"></i>
                    <span class="link-title">Process Simulation</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ show_class(['admin/master/process_simulation/*']) }}" id="process_simulation">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/process_simulation/type') }}" class="nav-link {{ active_class(['admin/master/process_simulation/type']) }}{{ active_class(['admin/master/process_simulation/type/*'])}}">Process Type</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/process_simulation/process_status') }}" class="nav-link {{ active_class(['admin/master/process_simulation/process_status']) }}{{ active_class(['admin/master/process_simulation/process_status/*'])}}">Process Status</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/process_simulation/category') }}" class="nav-link {{ active_class(['admin/master/process_simulation/category']) }}{{ active_class(['admin/master/process_simulation/category/*'])}}">Process Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/process_simulation/simulation_type') }}" class="nav-link {{ active_class(['admin/master/process_simulation/simulation_type']) }}{{ active_class(['admin/master/process_simulation/simulation_type/*'])}}"> Simulation Type</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/process_simulation/flow_type') }}" class="nav-link {{ active_class(['admin/master/process_simulation/flow_type']) }}{{ active_class(['admin/master/process_simulation/flow_type/*'])}}"> Flow Type</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ active_class(['admin/master/energy_utilities/*']) }}">
                <a class="nav-link" data-toggle="collapse" href="#energy_utilities" role="button" aria-expanded="{{ is_active_route(['admin/master/energy_utilities/*']) }}" aria-controls="energy_utilities">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Energy & Utilities</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ show_class(['admin/master/energy_utilities/*']) }}" id="energy_utilities">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/energy_utilities/property') }}" class="nav-link {{ active_class(['admin/master/energy_utilities/property']) }}{{ active_class(['admin/master/energy_utilities/property/*'])}}">Property</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/master/energy_utilities/sub_property') }}" class="nav-link {{ active_class(['admin/master/energy_utilities/sub_property']) }}{{ active_class(['admin/master/energy_utilities/sub_property/*'])}}">Sub Property</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ active_class(['admin/job-queue']) }}{{ active_class(['/admin/job-queue']) }}">
                <a href="{{ url('/admin/job-queue') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Job & Queue</span>
                </a>
            </li>
            <!-- <li class="nav-item {{ active_class(['admin/data_request']) }}{{ active_class(['/admin/data_request']) }}">
                <a href="{{ url('/admin/data_request') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Data Request</span>
                </a>
            </li> -->
        </ul>
    </div>
</nav>
