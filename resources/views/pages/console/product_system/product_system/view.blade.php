@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/product_system/product')}}">Product System</a></li>
        <li class="breadcrumb-item active">{{$data['name']}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for=""> Name
                            <i data-toggle="tooltip" title="" data-original-title="Enter Name." class="mdi mdi-information-outline"></i>
                        </label>
                        <input type="text" disabled class="form-control" value="{{$data['name']}}">
                        <input type="hidden" disabled id="prd_id" value="{{$data['id']}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for=""> Number Of Process
                            <i data-toggle="tooltip" title="" data-original-title="Enter Name." class="mdi mdi-information-outline"></i>
                        </label></br>
                        <input type="text" class="form-control" disabled value="{{$data['count']}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for=""> Selected Process Simulation
                            <i data-toggle="tooltip" title="" data-original-title="Enter Name." class="mdi mdi-information-outline"></i>
                        </label>
                        <ul class="list-group">
                            @if(!empty($data['process']))
                            @foreach($data['process'] as $pval)
                            <li class="list-group-item">
                                <a class="" href="{{url('/product_system/product/'.___encrypt($pval['id']).'/processSimprofile')}}" target="_blank"> {{$pval['process_name']}}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>

                </div>
                <div class="form-group col-md-12">
                    <p class="card-text float-right"><small class="text-muted">Last updated {{___ago($data['updated_at'])}}</small></p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex align-items-center flex-wrap text-nowrap float-right">
                    <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" id="mymodel" data-target=".mymodel">
                        <i class="fas fa-plus"></i> &nbsp;Add
                    </button>
                    <div class="deletebulk">
                        @if(!empty($data['profilelist']))
                        <button type="button" data-url="{{url('/product_system/profile/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger mb-2 mb-md-0">
                            <i class="fas fa-trash text-white"></i>Delete
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive pt-3">
                    <table class="table" id="product_profile_tbl">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Process number</th>
                            <th>Process Simulation</th>
                            <th>Product Input</th>
                            <th>Product Output</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @if(!empty($data['profilelist']))
                            @foreach($data['profilelist'] as $k =>$v)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($v['profile_id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>Process {{($k+1)}}</td>
                                <td>{{$v['process']}}</td>
                                <td>
                                    <ul class="list-group">
                                        @if(!empty($v['prd_input']))
                                        @foreach($v['prd_input'] as $prdIkey=>$prdIval)
                                        <li class="list-group-item">
                                            <b>{{$prdIval}}</b>
                                        </li>

                                        @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    <ul class="list-group">
                                        @if(!empty($v['prd_output']))
                                        @foreach($v['prd_output'] as $prdOkey =>$prdOval)
                                        <li class="list-group-item">
                                            <b>{{$prdOval}}</b>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $pfId = $v['profile_id'];
                                    ?>
                                    <a href="javascript:void(0);" data-url="{{url('/product_system/profile/'.___encrypt($pfId).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#mymodal{{$pfId}}" class="btn btn-sm text-secondary btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Edit Process">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{url('/product_system/profile/'.___encrypt($v['profile_id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Delete Process">
                                        <i class="fas fa-trash text-secondary"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="6"> No Records Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mymodel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{url('/product_system/profile')}}" method="POST" role="product_sys_profile">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="process">Select Process
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Simulation"></i></span>
                            </label>
                            <select id="SimProduct" name="SimPrcess" class="SimProduct" onchange="SimProducts(this.value)">
                                <option id="0">Select Process Simulation</option>
                                @if(!empty($data['process']))
                                @foreach($data['process'] as $pval)
                                <option value="{{$pval['id']}}">{{$pval['process_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" style="background-color:white ;" value="{{$data['id']}}" name="prd_system" id="prd_system">
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-10">
                                    <label for="prd_input">Select Product Input
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product Input"></i></span>
                                    </label>
                                    <select id="prdInput" name="prdInput[]" class="prdInput" onchange="prdInputvalidation(this.value,this)">
                                        <option value="0">Select Product Input</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button type="button" class="btn btn-icon" id="btnadd" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus text-secondary"></i>
                                    </button>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button type="button" disabled class="btn btn-icon" id="btndel" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fas fa-minus text-secondary"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="procees_prdInput" id="procees_prdInput">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-10">
                                    <label for="prd_output">Select Product Output
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product Output"></i></span>
                                    </label>
                                    <select id="prdOut" name="prdOut[]" class="js-example-basic-single w-100 prdOut" onchange="prdOutputvalidation(this.value, this)">
                                        <option value="0">Select Product Output</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button type="button" class="btn btn-icon" id="btnaddoutput" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus text-secondary"></i>
                                    </button>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button type="button" disabled class="btn btn-icon" id="btndeloutput" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="fas fa-minus text-secondary"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="procees_prdOutput" id="procees_prdOutput">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="product_sys_profile"]' class="btn btn-sm btn-secondary submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="edit-div">
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var selected = [];

    function prdInputvalidation(value, elmt) {
        debugger;
        if (selected.indexOf(value) !== -1) {
            swal.fire({
                text: "Value Already exists! \n Please Select Diffrent value to proceed",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            elmt.value = 0;
        } else if (selectedOut.indexOf(value) !== -1) {
            swal.fire({
                text: "Value Already exists as output! \n Please Select Diffrent value to proceed",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            elmt.value = 0;
        }
        selected = [];
        $('.prdInput :selected').each(function() {
            if ($(this).val() != "")
                selected.push($(this).val());
        });
        
    }

    var selectedOut = [];
    function prdOutputvalidation(value,elmt) {
        debugger;
        if (selectedOut.indexOf(value) !== -1) {
            swal.fire({
                text: "Value Already exists! \n Please Select Diffrent value to proceed",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            elmt.value = 0;
        } else if (selected.indexOf(value) !== -1) {
            debugger;
            swal.fire({
                text: "Value Already exists as input! \n Please Select Diffrent value to proceed",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            elmt.value = 0;
            
        }

        selectedOut = [];
        $('.prdOut :selected').each(function() {
            if ($(this).val() != "")
                selectedOut.push($(this).val());
        });
        
    }

    $('.deletebulk').hide();

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
        if ($('.checkSingle:checked').length>1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
    var jsonObj = {};

    function SimProducts(val) {

        prd_system = document.getElementById('prd_system').value;
        $('.prdInput').empty().append('<option  value="">Select Product Input</option>');
        $('.prdOut').empty().append('<option  value="">Select Product output</option>');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/product_system/product/simulationproduct') }}",
            method: 'GET',
            data: {
                id: val,
                prd_id: prd_system
            },
            success: function(result) {
                respObj = JSON.parse(result);
                jsonObj = respObj;
                objInputparse = respObj;
                if (respObj['err']) {
                    swal.fire({
                        text: respObj['err'],
                        confirmButtonText: 'Close',
                        confirmButtonClass: 'btn btn-danger',
                        width: '350px',
                        height: '10px',
                        icon: 'warning',
                    });
                    return false;
                }
                for (obj in respObj) {
                    if (respObj[obj].length != 0) {
                        $('.prdInput').append($('<option>', {
                            value: respObj[obj]['id'],
                            text: respObj[obj]['product']
                        }));
                        $('.prdOut').append($('<option>', {
                            value: respObj[obj]['id'],
                            text: respObj[obj]['product']
                        }));
                    }
                }
            }
        });
    }
    let cnt = 0;
    $(document).on('click', '#btnadd', function() {
        if (typeof respObj === 'undefined') {

            return false;
        }
        // color is undefined

        var html = '';
        html += '<div id="prdInputFormUnit">';
        html += '<div class="form-row">';
        html += '<div class = "form-group col-md-10" >';
        html += '<select id = "prdInput" name = "prdInput[]"  class = "prdInput" onclick="prdInputvalidation(this.value,this)">';
        html += '<option value = "0" > Select Product Input </option>';
        if (respObj) {

            for (i in respObj) {
                html += '<option value="' + respObj[i]['id'] + '">' + respObj[i]['product'] + '</option>';
            }

        }
        html += '</select>';
        html += '</div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button" class = "btn btn-sm text-secondary btn-icon" id = "btnadd" data - toggle = "tooltip" data - placement = "bottom" title = "Add">';
        html += '<i class = "fa fa-plus" > </i> </button> </div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button"  class = "btn btn-sm text-secondary btn-icon" id = "btndel" data - toggle = "tooltip" data - placement = "bottom" title = "delete" >';
        html += '<i class = "fa fa-minus" > </i> </button> </div> </div>';
        html += '<div class="procees_prdInput" id="procees_prdInput"></div>';
        html += '</div>';
        $('#procees_prdInput').append(html);
    });

    $(document).on('click', '#btndel', function() {
        $(this).closest('#prdInputFormUnit').remove();
    });

    $(document).on('click', '#btnaddoutput', function() {
        if (typeof respObj === 'undefined') {

            return false;
        }
        var html = '';
        html += '<div id="prdOutputFormUnit">';
        html += '<div class="form-row">';
        html += '<div class = "form-group col-md-10" >';
        html += '<select id = "prdOut" name = "prdOut[]" class = "prdOut" onclick="prdOutputvalidation(this.value,this)">';
        html += '<option value = "0" > Select Product Output </option>';
        if (respObj) {

            for (i in respObj) {
                html += '<option value="' + respObj[i]['id'] + '">' + respObj[i]['product'] + '</option>';
            }

        }

        html += '</select>';
        html += '</div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button" class = "btn btn-sm text-secondary" id = "btnaddoutput" data - toggle = "tooltip" data - placement = "bottom" title = "Add">';
        html += '<i class = "fa fa-plus" > </i> </button> </div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button"  class = "btn btn-sm text-secondary" id = "btndeloutput" data - toggle = "tooltip" data - placement = "bottom" title = "delete" >';
        html += '<i class = "fa fa-minus" > </i> </button> </div> </div>';
        html += '<div class="procees_prdOutput" id="procees_prdOutput"></div>';
        html += '</div>';
        $('#procees_prdOutput').append(html);
    });

    $(document).on('click', '#btndeloutput', function() {
        $(this).closest('#prdOutputFormUnit').remove();
    });
</script>
@endpush