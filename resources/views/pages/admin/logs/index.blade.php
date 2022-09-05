@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Activity Logs</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap"></div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive" >
                    <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-id-card icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">

                            @if (!empty($users))
                            @foreach ($users as $user)

                            <a class="dropdown-item table-filter-type" data-value="{{$user->first_name}}" href="#">{{$user->first_name}} {{$user->last_name}}</a>
                            @endforeach
                            <a class="dropdown-item table-filter-type" href="#" data-value="">Clear Filter</a>

                            @endif
                        </div>
                    </div>

                    {{-- <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">
                            {{-- @if (!empty($data ?? '' ?? '' ?? '')) --}}
                            {{-- @foreach ($userarray as $uname) --}}
                            {{-- <a class="dropdown-item table-filter" href="#" data-value=> </a> --}}
                            {{-- @endforeach --}}
                            {{-- <a class="dropdown-item table-filter" href="#" data-value=>Clear Filter</a> --}}
                            {{-- @endif
                        </div> --}}

                        <div class="btn-group float-right" style="margin-left:5px">
                            <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></button>
                            <div class="dropdown-menu" style="height: 280px" >

                                 @if (!empty($menu))
                                @foreach ($menu as $user)
                                <a class="dropdown-item table-filter-status" data-value="" href="">{{$user->name}}</a>
                                @endforeach
                                <a class="dropdown-item table-filter-status" href="#" data-value="">Clear Filter</a>
                                @endif

                            </div>
                        </div>
                        <div class="btn-group float-right" style="margin-left:5px">
                            <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></button>
                            <div class="dropdown-menu">

                                 @if (!empty($menu))
                                @foreach ($menu as $user)

                                <a class="dropdown-item table-filter" data-value="{{$user->name}}" href="#">{{$user->name}}</a>
                                @endforeach
                                <a class="dropdown-item table-filter" data-value="#" data-value="">Clear Filter</a>
                                @endif

                            </div>
                        </div>
                    </p>

                    <table id="log_list" class="table">
                        <thead>
                            <th>Tenent Name</th>
                            <th>User Name</th>
                            <th>Event Performed</th>
                            <th>Time</th>
                            <!-- <th>Actions</th> -->
                        </thead>
                        <tbody>
                            @if(!empty($object))
                            @foreach($object as $log)
                            <tr>
                                <td>{{isset($log['organization_name'])?$log['organization_name']:''}}</td>
                                <td>{{sizeof($log['data'])>0?$log['data']['username']:''}}</td>
                                <td>{{isset($log['event'])?$log['event']:''}}</td>
                                <td>{{isset($log['time'])?$log['time']:''}}</td>
                                {{-- <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" href="{{url('/admin/logs/1')}}" data-toggle="tooltip" data-placement="bottom" title="View Log">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                    </div>
                                </td> --}}
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
<script src="https://kit.fontawesome.com/c222dd3c0d.js" crossorigin="anonymous"></script>



@endpush

@push('custom-scripts')
<script>


    $(function() {

            var table = $('#log_list').DataTable({
                // "dom": 'lrtip',
                "iDisplayLength": 100,
                // dom: 'Blfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                "language": {
                    search: ""
                },
                "dom": "lrtip"
            });
            //  $('#table-filter').on('change', function() {
            //     var selectedValue = $("#table-filter").val();
            //     table.columns(6).search(selectedValue).draw();
            // });
            $('.table-filter').on('click', function() {

                var selectedValue = $(this).attr("data-value");
                table.columns(1).search(selectedValue).draw();
            });
            $('.table-filter-type').on('click',function() {
                var selectedValue = $(this).attr("data-value");
                table.columns(1).search(selectedValue).draw();
            });
            $('.table-filter-status').on('click', function() {
                var selectedValue = $(this).attr("data-value");
                table.columns(2).search(selectedValue).draw();
            });
            $('#myCustomSearchBox').keyup(function() {
                table.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
            })

            $('#').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find(
                    'div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find(
                    'div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });

    });

</script>
<script>
    $(function() {
        $('#log_list').DataTable({
            "dom": 'lrtip',
            "iDisplayLength": 100,
            dom: 'Blfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "language": {
                search: ""
            }
        });
    });
    $("#example-select-all").click(function() {
        $('.checkSingle').not(this).prop('checked', this.checked);
    });
</script>
@endpush
