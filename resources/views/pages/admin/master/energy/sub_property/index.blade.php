@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Energy Sub Properties</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Energy Sub Properties</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('/admin/master/energy_utilities/sub_property/create')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend " data-feather="plus"></i>
            Create Sub Property
        </a>
        <button type="button" data-url="{{url('/admin/master/energy_utilities/sub_property/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger deletebulk btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="class_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Main Property</th>
                                <th>Sub Property Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($sub_properties)
                            @endphp
                            @if(!empty($sub_properties))
                            @foreach($sub_properties as $sub_property)
                            <tr>
                                <td><input type="checkbox" value="{{$sub_property->id}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$sub_property->main_prop->property_name}}</td>
                                <td>{{$sub_property->sub_property_name}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/admin/master/energy_utilities/sub_property/'.___encrypt($sub_property->id).'?status='.$sub_property->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{$sub_property->id}}" @if($sub_property->status=='pending') disabled @endif
                                        @if($sub_property->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{$sub_property->id}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">

                                    <div class="btn-group btn-group-sm" role="group">
                                        
                                            <a href="{{ url('/admin/master/energy_utilities/sub_property/'.___encrypt($sub_property->id).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit sub property">
                                                <i class="fas fa-edit text-secondary"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('admin/master/energy_utilities/sub_property/'.___encrypt($sub_property->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete sub property">
                                                <i class="fas fa-trash text-secondary"></i>
                                            </a>

                                    </div>
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

@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    $(function() {
        if(cnt>10){
            $('#class_list').DataTable();
        }
    });
    $(".deletebulk").hide();
    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        $('.checkSingle').not(this).prop('checked', this.checked);
    });

    $('.checkSingle').click(function() {
        if ($('.checkSingle:checked').length == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
</script>
@endpush