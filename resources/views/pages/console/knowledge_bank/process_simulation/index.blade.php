@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Knowledge Bank Process </li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Knowledge Bank Process</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="user_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                <th>Process Name</th>
                                <th>Process Status</th>
                                <th>Simulation Stage</th>
                                <th>Data Category</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($data)
                            @endphp
                            @if(!empty($data))
                            @foreach($data as $key => $value)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($value['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$value['process_name']}}</td>
                                <td>
                                    @if(!empty($value['sim_stage']))
                                    @foreach($value['sim_stage'] as $simVal)

                                    <span class="badge badge-info">{{$simVal}}</span>

                                    @endforeach
                                    @endif
                                </td>
                                <td>{{$value['processCategory']}} </td>
                                <td>{{$value['processStatus']}}</td>
                                <td>

                                    <a href="{{ route('simulation.show',___encrypt($value['id']))}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Manage Process Simulation Profile">
                                        <i class="fas fa-cog text-secondary"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{url('/knowledge_bank/process_simulation/'.___encrypt($value['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Process Simulation">
                                        <i class="fas fa-trash text-secondary"></i>
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
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if(cnt>10){
        $('#user_list').DataTable();
    }
</script>
@endpush