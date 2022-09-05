<div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
    <div class="tab-pane fade show active" id="v-user" role="tabpanel" aria-labelledby="v-user-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">User Management</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/user/create')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="user-plus"></i>
                                    Add User
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user_list" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($data['users']))
                                    @foreach($data['users'] as $key =>$val)
                                    <tr>
                                        <td>{{ $val->first_name}} {{ $val->last_name}}</td>
                                        <td>{{ $val->email }} </td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/user/'.___encrypt($val->id).'?status='.$val->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($val->id)}}" @if($val->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($val->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/organization/user/'.___encrypt($val->id))}}" data-toggle="tooltip" data-placement="bottom" title="View Profile" type="button" class="btn btn-success">
                                                <i class="fa fa-eye text-white"></i>
                                            </a>
                                            <a href="{{url('/organization/user/'.___encrypt($val->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit User">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/user/'.___encrypt($val->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete User">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-department" role="tabpanel" aria-labelledby="v-department-tab">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Departments</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="/organization/department/create" class="btn btn-sm btn-secondary">Add Department</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            <table id="department_list" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($data['departments']))
                                    @foreach($data['departments'] as $key =>$val)
                                    <tr>
                                        <td>{{ $val->name}}</td>
                                        <td>{{ $val->description}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/department/'.___encrypt($val->id).'?status='.$val->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitchDepart{{___encrypt($val->id)}}" @if($val->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitchDepart{{___encrypt($val->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ URL::to('/organization/department/'.___encrypt($val->id)) }}" data-toggle="tooltip" data-placement="bottom" title="View Department" type="button" class="btn btn-success">
                                                <i class="fa fa-eye text-white"></i>
                                            </a>
                                            <a href="{{url('/organization/department/'.___encrypt($val->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Department">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/department/'.___encrypt($val->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Department">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-designation" role="tabpanel" aria-labelledby="v-designation-tab">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Designations</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="/organization/designation/create" class="btn btn-sm btn-secondary">Add Designation</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            <table id="designation_list" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Designation Name</th>
                                        <th>Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($data['designations']))
                                    @foreach($data['designations'] as $key =>$val)
                                    <tr>
                                        <td>{{ $val->name}}</td>
                                        <td>{{ $val->description}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/designation/'.___encrypt($val->id).'?status='.$val->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitchdesignation{{___encrypt($val->id)}}" @if($val->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitchdesignation{{___encrypt($val->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ URL::to('/organization/designation/'.___encrypt($val->id)) }}" data-toggle="tooltip" data-placement="bottom" title="View Profile" type="button" class="btn btn-success">
                                                <i class="fa fa-eye text-white"></i>
                                            </a>
                                            <a href="{{url('/organization/designation/'.___encrypt($val->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/designation/'.___encrypt($val->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Designation">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-employee" role="tabpanel" aria-labelledby="v-employee-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Employee Management</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/employee/create')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="users"></i>
                                    Add Employee
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            <table id="employee_list" class="table table-hover mb-0">
                                <thead>
                                    <th>Full Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Permissions</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['employees']))
                                    @foreach($data['employees'] as $employee)
                                    <tr>
                                        <td>@foreach($employee['users'] as $val){{ $val->first_name }} {{ $val->last_name }}@endforeach</td>
                                        <td>@foreach($employee['departments'] as $val){{ $val->name }}@endforeach</td>
                                        <td>@foreach($employee['designations'] as $val){{ $val->name }}@endforeach</td>
                                        <td></td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/employee/'.___encrypt($employee->id).'?status='.$employee->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($employee->id)}}" @if($employee->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($employee->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('/organization/employee/'.___encrypt($employee->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/employee/'.___encrypt($employee->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Employee">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-process_exp" role="tabpanel" aria-labelledby="v-process_exp-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Experiment</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/process_experiment/category')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                                    <i class="btn-icon-prepend" data-feather="globe"></i>
                                    Manage Category
                                </a>
                                <a href="{{url('/organization/process_experiment/classification')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="globe"></i>
                                    Manage Classification
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-12 table mb-3">
                            <table id="process_experiment_categories" class="table table-hover mb-0">
                                <thead>
                                    <th>Category Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['experiment_categories']))
                                    @foreach($data['experiment_categories'] as $category)
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/process_experiment/category/'.___encrypt($category->id).'?status='.$category->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($category->id)}}" @if($category->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($category->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('/organization/process_experiment/category/'.___encrypt($category->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment Category">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/process_experiment/category/'.___encrypt($category->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Experiment Category">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 table">
                            <table id="process_experiment_classifications" class="table table-hover mb-0">
                                <thead>
                                    <th>Classification Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['experiment_classifications']))
                                    @foreach($data['experiment_classifications'] as $classification)
                                    <tr>
                                        <td>{{$classification->name}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/process_experiment/classification/'.___encrypt($classification->id).'?status='.$classification->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($classification->id)}}" @if($classification->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($classification->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('/organization/process_experiment/classification/'.___encrypt($classification->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment Classification">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/process_experiment/classification/'.___encrypt($classification->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Experiment Classification">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-equipment_unit" role="tabpanel" aria-labelledby="v-equipment_unit-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Experiment - Equipment Unit</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/process_experiment/equipment_unit/create')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="users"></i>
                                    Create Equipment Unit
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            <table id="equipment_unit_list" class="table table-hover mb-0">
                                <thead>
                                    <th>Equipment Unit Name</th>
                                    <th>Equipment Image</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['equipment_units']))
                                    @foreach($data['equipment_units'] as $equipment_unit)
                                    <tr>
                                        <td>{{$equipment_unit->equipment_name}}</td>
                                        @if(!empty($equipment_unit->exp_unit_image->image))
                                        <td><img src="{{$equipment_unit->exp_unit_image->image}}" height="200" width="200"></td>
                                        @else
                                        <td>none</td>
                                        @endif
                                        @php
                                        $user = check_user_type($equipment_unit->created_by);
                                        @endphp
                                        <td class="text-center">
                                            @if($user->role!='admin')
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" data-url="{{url('/organization/process_experiment/equipment_unit/'.___encrypt($equipment_unit->id).'?status='.$equipment_unit->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{___encrypt($equipment_unit->id)}}" @if($equipment_unit->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{$equipment_unit->id}}"></label>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/organization/process_experiment/equipment_unit/'.___encrypt($equipment_unit->id)) }}" data-toggle="tooltip" data-placement="bottom" title="View Profile" type="button" class="btn btn-success">
                                                <i class="fa fa-eye text-white"></i>
                                            </a>
                                            @if($user->role!='admin')
                                            <a href="{{url('/organization/process_experiment/equipment_unit/'.___encrypt($equipment_unit->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/process_experiment/equipment_unit/'.___encrypt($equipment_unit->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Experiment Equipment Unit">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-lists" role="tabpanel" aria-labelledby="v-lists-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Lists</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/list/category')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                                    <i class="btn-icon-prepend" data-feather="globe"></i>
                                    Manage Category
                                </a>
                                <a href="{{url('/organization/list/classification')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="globe"></i>
                                    Manage Classification
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-12 table mb-3">
                            <table id="list_categories" class="table table-hover mb-0">
                                <thead>
                                    <th>Category Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['list_categories']))
                                    @foreach($data['list_categories'] as $category)
                                    <tr>
                                        <td>{{$category->category_name}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/list/category/'.___encrypt($category->id).'?status='.$category->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($category->id)}}" @if($category->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($category->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('/organization/list/category/'.___encrypt($category->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit List Category">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/list/category/'.___encrypt($category->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete List Category">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 table">
                            <table id="list_classifications" class="table table-hover mb-0">
                                <thead>
                                    <th>Classification Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['list_classifications']))
                                    @foreach($data['list_classifications'] as $classification)
                                    <tr>
                                        <td>{{$classification->classification_name}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/list/classification/'.___encrypt($classification->id).'?status='.$classification->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($classification->id)}}" @if($classification->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($classification->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/organization/list/classification/'.___encrypt($classification->id).'/edit') }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit List Classification">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{ url('/organization/list/classification/'.___encrypt($classification->id)) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete List Classification">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-vendor" role="tabpanel" aria-labelledby="v-vendor-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Vendor Master</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/vendor/category')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                                    <i class="btn-icon-prepend" data-feather="globe"></i>
                                    Manage Category
                                </a>
                                <a href="{{url('/organization/vendor/classification')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="globe"></i>
                                    Manage Classification
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-12 table mb-3">
                            <table id="vendor_categories" class="table table-hover mb-0">
                                <thead>
                                    <th>Category Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['vendor_categories']))
                                    @foreach($data['vendor_categories'] as $category)
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/vendor/category/'.___encrypt($category->id).'?status='.$category->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($category->id)}}" @if($category->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($category->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('/organization/vendor/category/'.___encrypt($category->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/vendor/category/'.___encrypt($category->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Employee">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 table">
                            <table id="vendor_classifications" class="table table-hover mb-0">
                                <thead>
                                    <th>Classification Name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['vendor_classifications']))
                                    @foreach($data['vendor_classifications'] as $classification)
                                    <tr>
                                        <td>{{$classification->name}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/organization/vendor/classification/'.___encrypt($classification->id).'?status='.$classification->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($classification->id)}}" @if($classification->status=='active') checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($classification->id)}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('/organization/vendor/classification/'.___encrypt($classification->id).'/edit')}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('/organization/vendor/classification/'.___encrypt($classification->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Vendor Classification">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="v-backup_config" role="tabpanel" aria-labelledby="v-backup_config-tab">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-md-0">Database Backup Configuration</h4>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <a href="{{url('/organization/backup')}}" class="btn btn-sm btn-secondary btn-icon-text mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="database"></i>
                                    Manage Database Backup Configuration
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>