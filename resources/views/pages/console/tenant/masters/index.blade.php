<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                            User Management - {{$data['user_count']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-cog fa-2x text-secondary text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <p class="card-text">
                    <small class="text-muted">Last updated {{___ago($data['user_last_update']['updated_at'])}}</small>
                </p>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/user/create')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                            <i data-feather="user-plus" class="icon-sm mr-2"></i> <span class="">Create</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/user')}}" toggle="tooltip" data-placement="top" title="View Product">
                            <i data-feather="list" class="icon-sm mr-2"></i> <span class="">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                            Department - {{$data['departments_count']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-circle fa-2x text-secondary text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <p class="card-text">
                    <small class="text-muted">Last updated {{___ago($data['departments__last_update']['updated_at'])}}</small>
                </p>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/department/create')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                            <i data-feather="plus" class="icon-sm mr-2"></i> <span class="">Create</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/department')}}" toggle="tooltip" data-placement="top" title="View Product">
                            <i data-feather="list" class="icon-sm mr-2"></i> <span class="">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                            Designation - {{$data['designations_counts']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-secondary text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <p class="card-text">
                    <small class="text-muted">Last updated {{___ago($data['designation__last_update']['updated_at'])}}</small>
                </p>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/designation/create')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                            <i data-feather="plus" class="icon-sm mr-2"></i> <span class="">Create</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/designation')}}" toggle="tooltip" data-placement="top" title="View Product">
                            <i data-feather="list" class="icon-sm mr-2"></i> <span class="">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                            Employee - {{$data['employees_counts']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-portrait fa-2x text-secondary text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <p class="card-text">
                    <small class="text-muted">Last updated {{___ago($data['employee__last_update']['updated_at'])}}</small>
                </p>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/employee/create')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                            <i data-feather="plus" class="icon-sm mr-2"></i> <span class="">Create</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/employee')}}" toggle="tooltip" data-placement="top" title="View Product">
                            <i data-feather="list" class="icon-sm mr-2"></i> <span class="">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                            Equipment units - {{$data['equipment_units_counts']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-vials fa-2x text-secondary text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <p class="card-text">
                    <small class="text-muted">Last updated {{___ago($data['equipment__last_update']['updated_at'])}}</small>
                </p>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/process_experiment/equipment_unit/create')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                            <i data-feather="plus" class="icon-sm mr-2"></i> <span class="">Create</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/process_experiment/equipment_unit')}}" toggle="tooltip" data-placement="top" title="View Product">
                            <i data-feather="list" class="icon-sm mr-2"></i> <span class="">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                            Database Backups - {{$data['equipment_units_counts']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-vials fa-2x text-secondary text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <p class="card-text">
                    <small class="text-muted">Last updated {{___ago($data['equipment__last_update']['updated_at'])}}</small>
                </p>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/process_experiment/equipment_unit/create')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                            <i data-feather="plus" class="icon-sm mr-2"></i> <span class="">Manage</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="{{url('organization/backup')}}" toggle="tooltip" data-placement="top" title="View Product">
                            <i data-feather="list" class="icon-sm mr-2"></i> <span class="">View All</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>