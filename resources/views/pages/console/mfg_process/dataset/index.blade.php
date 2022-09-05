<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin float-right mt-0 mr-0">
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <!-- if($process_info['viewflag']!="view") -->
        @php
        //$per = request()->get('sub_menu_permission');
        //$permission=!empty($per['dataset']['method'])?$per['dataset']['method']:[];
        $permission=['create','edit','index','manage','delete'];
        @endphp
        @if($process_info['viewflag']!='view')
        @if(in_array('create',$permission))
        <button type="button"  class="btn btn-sm btn-secondary btn-icon-text  d-none d-md-block" data-toggle="modal" data-target="#configModal" data-toggle="tooltip" data-placement="bottom" title="Save dataset">
            <i class="fas fa-plus"></i>&nbsp;&nbsp;
            Add Process Dataset
        </button>&nbsp;
        @endif
        @if(in_array('delete',$permission))
        <div class="deletebulk_configuration" style="display: none;">
            <button type="button" onclick="bulkdelDataset()" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash" ></i>&nbsp;
                Delete
            </button>
        </div>
        @endif
        @endif
        <!-- endif -->
    </div>
</div>
<div class="table-responsive">
    <table id="view_config_table" class="table font-weight-normal">
        <thead>
            @if($process_info['viewflag']!="view")
            <th>
                <input type="checkbox" name="example-select-all_dataset" value="1" id="example-select-all_dataset">
            </th>
            @endif
            <th>Dataset Name </th>
            <th>Simulation Type</th>
            <th>Data Source</th>
            <th>Created By</th>
            <th>Created Date</th>
            <th>Updated By</th>
            <th>Updated Date</th>
            <th class="">Status</th>
            <th class="text-center">Actions</th>
        </thead>
        <tbody>
            @php
            $dataset_cnt=count($process_info['process_datasets']);
            //$per = request()->get('sub_menu_permission');
            //$permission=!empty($per['dataset']['method'])?$per['dataset']['method']:[];
            //$simulation_input_per=!empty($per['simulation_input']['method'])?$per['simulation_input']['method']:[];
            @endphp
            @if(!empty($process_info['process_datasets']))
            @foreach($process_info['process_datasets'] as $process_datasets)
            <tr>
                @php
                $datasetid=___encrypt($process_datasets["id"]);
                $processid=___encrypt($process_datasets["process_id"]);
                $status=$process_datasets['status'];
                $simulationtype = get_simulation_stage($process_datasets['simulation_type']);
                @endphp
                @if($process_info['viewflag']!="view")
                <td>
                    <input type="checkbox" value="{{___encrypt($process_datasets['id'])}}" class="checkSingle_dataset" name="select_all_dataset[]">
                </td>
                @endif
                <td>{{$process_datasets['dataset_name']}}</td>
                <td class="text-center">{{$simulationtype['simulation_name']}}</td>
                <td>{{$process_datasets['data_source']['mass_balance']}}</td>
                <td>{{get_user_name($process_datasets['created_by'])}}</td>
                <td>{{dateTimeFormate($process_datasets['created_at'])}}</td>
                <td>{{get_user_name($process_datasets['updated_by'])}}</td>
                <td>{{dateTimeFormate($process_datasets['updated_at'])}}</td>
                <td>
                    @if($process_info['viewflag']!="view")
                    @if(Auth::user()->role == 'admin')
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch{{___encrypt($process_datasets['id'])}}" onchange="datasetstatus('{{$status}}','{{$datasetid}}','{{($processid)}}')" @if($process_datasets['status']=='active' ) checked @endif>
                        <label class="custom-control-label" for="customSwitch{{___encrypt($process_datasets['id'])}}"></label>
                    </div>
                    @else
                    @if($process_datasets['status'] == "active")
                    Ready to use
                    @else
                    Input Incompleted
                    @endif
                    @endif
                    @else
                    @if($process_datasets['status'] == "active")
                    Ready to use
                    @else
                    Input Incompleted
                    @endif
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        @if($process_info['viewflag']!="view")
                        @if($process_datasets['status'] == "active")
                        <a 
                        @if(in_array('index',$permission))
                        href="{{url('mfg_process/simulation/'.___encrypt($process_datasets['id']).'/dataset_config')}}" 
                        @endif
                        class="btn btn-icon" data-toggle="tooltip" type="button" data-placement="bottom" title="Edit dataset data">
                            <i class="fas fa-cog text-secondary"></i>
                        </a>
                        @else
                        @php
                        $name=$process_datasets['dataset_name'];
                        @endphp
                        <a href="javascript:void(0);" onclick="statusAlert('{{$name}}')" class="btn btn-icon" data-toggle="tooltip" type="button" data-placement="bottom" title="This dataset is still not ready for use.">
                            <i class="fas fa-cog text-secondary"></i>
                        </a>
                        @endif
                        @endif
                        @if($process_info['viewflag']!="view")
                        <a href="javascript:void(0);" @if(in_array('edit',$permission)) onclick="editdataset('{{$datasetid}}','{{$processid}}')" @else data-request="ajax-permission-denied" @endif class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit dataset">
                            <i class="fas fa-edit text-secondary"></i>
                        </a>
                        @endif
                        <!-- @if(in_array('view',$permission)) onclick="getdatasetView('{{$datasetid}}','{{$processid}}')" @else data-request="ajax-permission-denied" @endif -->
                        <a href="{{url('mfg_process/simulation/'.___encrypt($process_datasets['id']).'/view_config')}}"  class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" type="button" title="View dataset">
                            <i class="fas fa-eye text-secondary"></i>
                        </a>
                        @if($process_info['viewflag']!="view")
                        @if($process_datasets['status'] == "active")
                        <a type="button" onclick="getView('{{___encrypt($process_datasets['process_id'])}}','{{___encrypt($process_datasets['id'])}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Report">
                            <i class="fas fa-file-export text-secondary"></i>
                        </a>
                        @else
                        @php
                        $name=$process_datasets['dataset_name'];
                        @endphp
                        <a href="javascript:void(0);" onclick="statusAlert('{{$name}}')" class="btn btn-icon" data-toggle="tooltip" type="button" data-placement="bottom" title="This dataset is still not ready for use.">
                            <i class="fas fa-file-export text-secondary"></i>
                        </a>
                        @endif
                        <a href="javascript:void(0);" class="btn btn-icon" @if(in_array('delete',$permission)) onclick=" deletedataset('{{$datasetid}}')" @else  data-request="ajax-permission-denied" @endif data-toggle="tooltip" data-placement="bottom" title="Delete Dataset">
                            <i class="fas fa-trash text-secondary"></i>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">No records Found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="modal fade bd-example-modal-lg" id="configModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/mfg_process/simulation/'.$process_info['id'].'/dataset') }}" method="POST" role="process_config">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Add Process Dataset</h5>
                    <button type="button" id="configModalClose" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Dataset Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Dataset Name"></i></span>
                            </label>
                            <input type="text" id="dataset_name" name="dataset_name" class="form-control" value="" placeholder="Dataset Name">
                            <input type="hidden" id="process_id" name="process_id" class="form-control" value="{{$process_info['id']}}">
                            <input type="hidden" id="energy_data_source_input" name="energy_data_source_input" class="form-control" value="0">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Process Simulation Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="dataset Name"></i></span>
                            </label>
                            <select class="form-control" id="simulation_type" name="simulation_type" onchange="set_datasource()">
                                <option selected disabled value="">Select Simulation Type</option>
                                @if(!empty($process_info['simulationtype']))
                                @foreach($process_info['simulationtype'] as $stype)
                                <option value="{{___encrypt($stype->id)}}" data-energy="{{!empty($stype->enery_utilities)?1:0}}">{{$stype->simulation_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Mass Balance Data Source
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Data Source"></i></span>
                            </label>
                            <select class="form-control" id="mass_data_source" name="mass_data_source">
                                <option selected disabled value="">Select Data Source</option>
                                <option value="Basic User Input">Basic User Input</option>
                                <option value="Process Chemistry">Process Chemistry</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" id="energy_data_source_div" style="display:none">
                            <label class="control-label">Energy Balance Data Source
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Data Source"></i></span>
                            </label>
                            <select class="form-control" id="energy_data_source" name="energy_data_source">
                                <option selected disabled value="">Select Data Source</option>
                                <option value="Basic User Input">Basic User Input</option>
                                <option value="Process Chemistry">Process Chemistry</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="process_config"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                <!-- <button type="button" onclick="saveDataset()" class="btn btn-sm btn-secondary submit">Submit</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editdataset"></div>
<div class="modal fade bd-example-modal-sm generate_report" id="setoutputModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Generate Process Simulation Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="process_experiment">Report Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter name"></i></span>
                        </label>
                        <input type="text" id="report_name" name="report_name" value="" class="form-control" placeholder="Report Name">
                        <span class="text-danger" id="name-error" style="display:none">Report name field is required</span>
                    </div>
                    <input type="hidden" id="process_id" name=" process_id" class="form-control" required>
                    <input type="hidden" id="dataset_id" name="dataset_id" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveData()" class="btn btn-secondary btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    dataset_cnt="{{$dataset_cnt}}"
    if (dataset_cnt > 10) {
        $('#view_config_table').DataTable({
            "iDisplayLength": 100,
            // dom: 'Blfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            "language": {
                search: ""
            }
        });
    }

    $("#example-select-all_dataset").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_configuration").show();
        } else {
            $(".deletebulk_configuration").hide();
        }
        $('.checkSingle_dataset').not(this).prop('checked', this.checked);
        $('.checkSingle_dataset').click(function() {

            if ($('.checkSingle_dataset: checked ').length == $('.checkSingle_dataset').length) {
                $('#example-select-all_dataset').prop('checked', true);
            } else {
                $('#example-select-all_dataset').prop('checked', false);
            }
        });
    });
    $('.checkSingle_dataset').click(function() {
        var len = $("[name='select_all_dataset[]']:checked").length;

        if (len > 1) {
            $(".deletebulk_configuration").show();
        } else {
            $(".deletebulk_configuration").hide();
        }
    });

    function set_datasource(){
        var simulation_type = $("#simulation_type").find(':selected').attr('data-energy');
        $("#energy_data_source_input").val(simulation_type);
        if(simulation_type ==1){
            $("#energy_data_source_div").show();
        }else{
            $("#energy_data_source_div").hide();
        }
    }

    // function saveDataset() {
    //     var fd = new FormData();
    //     var dataset_name = $('#dataset_name').val();
    //     var process_id = $('#process_id').val();
    //     var simulation_type = $('#simulation_type').val();
    //     var mass_data_source = $('#mass_data_source').val();
    //     var energy_data_source = $('#energy_data_source').val();
    //     var data_energy = $("#simulation_type").find(':selected').attr('data-energy');
    //     // Check file selected or not
    //     var error_msg=""
    //     if (dataset_name =="") {
    //         var error_msg = "Please Enter Dataset Name"
    //     }
    //     if (error_msg=="" && simulation_type ==null) {
    //         var error_msg = "Please Select Simulation Type"
    //     }
    //     if (error_msg=="" && mass_data_source ==null) {
    //         var error_msg = "Please Select Mass Data Source"
    //     }
    //     if (error_msg=="" && energy_data_source ==null && data_energy==1) {
    //         var error_msg = "Please Select Energy Data Source"
    //     }
    //     if(error_msg!=""){
    //         swal.fire({
    //             text: error_msg,
    //             confirmButtonText: 'Close',
    //             confirmButtonClass: 'btn btn-sm btn-danger',
    //             width: '350px',
    //             height: '10px',
    //             icon: 'warning',
    //         });
    //         return false;
    //     }
    //         fd.append('dataset_name', dataset_name);
    //         fd.append('process_id', process_id);
    //         fd.append('simulation_type', simulation_type);
    //         fd.append('mass_data_source', mass_data_source);
    //         fd.append('energy_data_source', energy_data_source);
    //         event.preventDefault();
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         $.ajax({
    //             url: "{{ url('/mfg_process/simulation/'.$process_info['id'].'/dataset') }}",
    //             type: 'post',
    //             data: fd,
    //             contentType: false,
    //             processData: false,
    //             success: function(response) {
    //                 if (response.status == true) {
    //                     const Toast = Swal.mixin({
    //                         toast: true,
    //                         position: "top-end",
    //                         showConfirmButton: false,
    //                         timer: 5000,
    //                     });
    //                     Toast.fire({
    //                         icon: 'success',
    //                         title: "Dataset Added",
    //                     });
    //                     $('#configModalClose').trigger('click');
    //                     $(".modal-backdrop").hide();
    //                     $("#configModal").modal('hide');
    //                     $('#dataset_name').val('');
    //                     $('#config_description').val('');
    //                     $('#configuration_view_tab').trigger('click')

    //                 }
    //             },
    //         });
        
    // }

    function datasetstatus(val, id, p_id) {
        $('#expprofileSpinner').show();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You Want to Update Status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/mfg_process/simulation/dataset/status') }}",
                    method: 'POST',
                    data: {
                        p_id: p_id,
                        dataset_id: id,
                        val: val
                    },
                    success: function(result) {
                        $('#configuration_view_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Status Updated",
                        })
                        $('#expprofileSpinner').hide();
                    }
                });
                swalWithBootstrapButtons.fire(
                    'Updated!',
                    ' Status Updated .',
                    'success'
                )
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    '',
                    'error'
                )
                $('#configuration_view_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })
    }

    function editdataset(id, processid) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('/mfg_process/simulation/'.$process_info['id'].'/dataset/') }}/"+id+"/edit",
            method: 'get',
            success: function(result) {
                $("#editdataset").html(result.html);
                $('#expprofileSpinner').hide();
                $("#editconfigModal").modal('show');
            }
        });
    }

    function statusAlert(value) {
        swal.fire({
            text: value + "  dataset is still not ready for use. Please specify information and request data/model from Simreka team to enable use",
            confirmButtonText: 'Close',
            confirmButtonClass: 'btn btn-sm btn-danger',
            width: '350px',
            height: '10px',
            icon: 'warning',
        });
        return false;
    }

    function deletedataset(id) {
        $('#expprofileSpinner').show();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You Want to Delete?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/mfg_process/simulation/'.$process_info['id'].'/dataset/delete') }}",
                    method: 'delete',
                    data: {
                        id: id,
                    },
                    success: function(result) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Dataset Deleted",
                        })
                        $('#configuration_view_tab').trigger('click')
                        $('#expprofileSpinner').hide();
                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Dataset Deleted .',
                    'success'
                )
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    '',
                    'error'
                )
                $('#configuration_view_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })
    }

    function bulkdelDataset() {
        var len = $("[name='select_all_dataset[]']:checked").length;
        if (len == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        var values = $("input[name='select_all_dataset[]']:checked")
            .map(function() {
                return $(this).val();
            })
            .get();
        $('#expprofileSpinner').show();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You Want to Delete?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/mfg_process/simulation/dataset/bulkdelete') }}",
                    method: 'POST',
                    data: {
                        ids: values,
                    },
                    success: function(result) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: " Deleted",
                        })
                        $('#configuration_view_tab').trigger('click')
                        $('#expprofileSpinner').hide();
                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Deleted .',
                    'success'
                )
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    '',
                    'error'
                )
                $('#configuration_view_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })
    }

    function getdatasetView(datasetid, processid) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/mfg_process/simulation/view_dataset') }}",
            method: 'POST',
            data: {
                id: datasetid,
                process_experiment_id: process_experiment_id,
                viewflag: viewflag

            },
            success: function(result) {
                $('#view_config_data').html('');
                $('#view_config_data').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getView(process_id, dataset_id) {
        $('#process_id').val(process_id);
        $('#dataset_id').val(dataset_id);
        $(".generate_report").modal("show");
    }

    async function saveData() {
        let result;
        $("#name-error").hide();
        report_name = document.getElementById('report_name').value;
        if (report_name == "") {
            $("#name-error").show();
            return false;
        }
        dataset_id = document.getElementById('dataset_id').value;
        process_id = document.getElementById('process_id').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        try {
            result = await $.ajax({
                url: "{{ url('/reports/process_analysis') }}",
                method: 'POST',
                data: {
                    report_name: report_name,
                    dataset_id: dataset_id,
                    process_id: process_id,
                }
            });
            if (result && result.success == "pending") {
                swal.fire({
                    text: "Report is in Process!, Once Process Done You can proceed for next report",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                document.getElementById('report_name').value = "";
                $(".generate_report").modal("hide");
                // let url = "{{ url('reports/experiment') }}";
                // window.open(url, '_blank');
                return false;
            }
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 5000,
            });
            Toast.fire({
                icon: 'success',
                title: "Report Created",
            })
            document.getElementById('report_name').value = "";
            $(".generate_report").modal("hide");
            let url = "{{ url('reports/process_analysis') }}";
            window.open(url, '_blank');
        } catch (error) {
            console.error(error);
        }
    }
    
</script>
