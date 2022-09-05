<div class="table-responsive">
    <table id="view_config_table" class="table font-weight-normal">
    @php
            $variation_cnt=count($process_experiment_info['variation_details']);
            $per = request()->get('sub_menu_permission');
            $permission=!empty($per['variation']['method'])?$per['variation']['method']:[];
            $simulation_input_per=!empty($per['simulation_input']['method'])?$per['simulation_input']['method']:[];
            @endphp
    @if($variation_cnt>10)
    <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-filter icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item table-filter-status" href="#" data-value="succ">Active</a>                          
                            <a class="dropdown-item table-filter-status" href="#" data-value="inactive">Inactive</a>
                            <a class="dropdown-item table-filter-status" href="#" data-value="">Clear Filter</a>
                        </div>
                    </div>
                    @endif
        <thead>
            @if($viewflag=="manage")
            <th>
                <input type="checkbox" name="example-select-all_variation" value="1" id="example-select-all_variation">
            </th>
            @endif
            <th>Variation Name </th>
            <th>Simulation Inputs</th>
            <!-- <th>Description</th> -->
            <th>Created By</th>
            <th>Created Date</th>
            <th>Updated By</th>
            <th>Updated Date</th>
            <th class="">Status</th>
            <th class="text-center">Actions</th>
        </thead>
        <tbody>
           
            @if(!empty($process_experiment_info['variation_details']))
            @foreach($process_experiment_info['variation_details'] as $variation_details)
            <tr>
                @php
                $vid=___encrypt($variation_details["id"]);
                $expid=___encrypt($variation_details["experiment_id"]);
                $status=$variation_details['status'];
                @endphp
                @if($viewflag=="manage")
                <td>
                    <input type="checkbox" value="{{___encrypt($variation_details['id'])}}" class="checkSingle_variation" name="select_all_variation[]">
                </td>
                @endif
                <td>{{$variation_details['variation_name']}}</td>
                <td class="text-center">{{$variation_details['total_no_simulation']}}</td>
                <!-- <td>{{$variation_details['description']}}</td> -->
                <td>{{$variation_details['created_by']}}</td>
                <td>{{$variation_details['created_at']}}</td>
                <td>{{$variation_details['updated_by']}}</td>
                <td>{{$variation_details['updated_at']}}</td>
                <td>
                <span style="display:none" class="hide_status">
                
                @if($variation_details['status']=="active")
               succ 
               @else
               {{$variation_details['status']}}
               @endif
       
       
               </span>
               @if($viewflag=="manage")
                    @if(Auth::user()->role == 'admin')
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch{{___encrypt($variation_details['id'])}}" onchange="variationstatus('{{$status}}','{{$vid}}','{{($expid)}}')" @if($variation_details['status']=='active' ) checked @endif>
                        <label class="custom-control-label" for="customSwitch{{___encrypt($variation_details['id'])}}"></label>
                    </div>
                    @else
                    @if($variation_details['status'] == "active")
                    Ready to use
                    @else
                    Input Incompleted
                    @endif
                    @endif
                    @else
                    @if($variation_details['status'] == "active")
                    Ready to use
                    @else
                    Input Incompleted
                    @endif
                    @endif
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        @if($viewflag=="manage")
                        @if($variation_details['status'] == "active")
                        @if(in_array('index',$simulation_input_per))
                        <a href="{{url('experiment/experiment/'.___encrypt($variation_details['id']).'/sim_config')}}" class="btn btn-icon" target="_blank" data-toggle="tooltip" type="button" data-placement="bottom" title="View Simulation Inputs">
                            <i class="fas fa-cog text-secondary"></i>
                        </a>
                        @endif
                        @else
                        @php
                        $name=$variation_details['variation_name'];
                        @endphp
                        <a href="javascript:void(0);" onclick="statusAlert('{{$name}}')" class="btn btn-icon" data-toggle="tooltip" type="button" data-placement="bottom" title="This variation is still not ready for use.">
                            <i class="fas fa-cog text-secondary"></i>
                        </a>
                        @endif
                        @else
                        <a href="{{url('experiment/experiment/'.___encrypt($variation_details['id']).'/view_config')}}" class="btn btn-icon" target="_blank" data-toggle="tooltip" type="button" data-placement="bottom" title="Manage Simulation Inputs">
                            <i class="fas fa-cog text-secondary"></i>
                        </a>
                        @endif
                        @if($viewflag=="manage")
                        @if(in_array('edit',$permission))
                        <!-- <a href="javascript:void(0);" onclick="editVartion('{{$vid}}','{{$expid}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Variation">
                            <i class="fas fa-edit text-secondary"></i>
                        </a> -->
                        @endif
                        @endif
                        <!-- onclick="getVariationView('{{$vid}}','{{$expid}}')" @if(in_array('view',$permission)) onclick="getVariationView('{{$vid}}','{{$expid}}')" @else data-request="ajax-permission-denied" @endif -->
                        @if(in_array('edit',$permission))
                        <a href="{{ url('/experiment/experiment/view_varition?id='.$vid.'&process_experiment_id='.$expid) }}"  class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" type="button" title="Edit Variation Data">
                            <i class="fas fa-edit text-secondary"></i>
                        </a>
                        @endif
                        @if($viewflag=="manage")
                        @if(in_array('create',$permission))
                        <a href="javascript:void(0);" onclick='cloneExpVar("{{$vid}}")' type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Clone Experiment Variation">
                            <i class="fas fa-copy text-secondary"></i>
                        </a>
                        @endif
                        @if(in_array('delete',$permission))
                        <a href="javascript:void(0);" class="btn btn-icon" onclick=" deleteVaration('{{$vid}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Experiment Varation">
                            <i class="fas fa-trash text-secondary"></i>
                        </a>
                        @endif

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

<div class="modal fade bd-example-modal-md variation_model" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="text-center">
                <div id="expprofileSpinner1" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Clone Variation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="process_experiment">Enter Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Report Name"></i></span>
                        </label>
                        <input type="text" id="vname" name="vname" class="form-control" placeholder="Name">
                        <input type="hidden" id="vid" name="vid" class="form-control" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="saveVariationData()" class="btn btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.hide_status').hide();
    var variation_cnt = '{{$variation_cnt}}';
    if (variation_cnt > 10) {
        var table = $('#view_config_table').DataTable({
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
            $('.table-filter-status').on('click', function() {
                var selectedValue = $(this).attr("data-value");
                
                table.columns(7).search(selectedValue).draw();
            });
        $('#view_config_table').each(function() {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.removeClass('form-control-sm');
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });
    }

    function cloneExpVar(val) {
        var variation_id = val;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Do you want to give Variation name?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                document.getElementById('vid').value = variation_id;
                $(".variation_model").modal("show");
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                if (variation_id != "") {
                    var objectexp = {
                        "tab": "clone",
                        "variation_id": variation_id
                    };
                    document.getElementById('expprofileSpinner').style.display = '';
                    event.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/experiment/experiment/cloneVariation") }}',
                        data: JSON.stringify(objectexp),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            if (data.success === true) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.errors,
                                })
                            }
                            document.getElementById('expprofileSpinner').style.display = 'none';
                            $('#configuration_view_tab').trigger('click')
                            $('#expprofileSpinner').hide();
                        },
                    });
                }
            }
        })
    }

    function saveVariationData() {
        var variation_id = document.getElementById('vid').value;
        if (variation_id != "") {
            var objectexp = {
                "tab": "clone",
                "variation_id": document.getElementById('vid').value,
                "name": document.getElementById('vname').value
            };
            document.getElementById('expprofileSpinner1').style.display = '';
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experiment/cloneVariation") }}',
                data: JSON.stringify(objectexp),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success === true) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors,
                        })
                    }
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(".variation_model").modal("hide");
                    $('#configuration_view_tab').trigger('click')
                    $('#expprofileSpinner').hide();

                },
            });
        }
    }

    function variationstatus(val, id, pe_id) {
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
                    url: "{{ url('/experiment/variation/status') }}",
                    method: 'POST',
                    data: {
                        pe_id: pe_id,
                        variation_id: id,
                        val: val
                    },
                    success: function(result) {
                        $('#configuration_view_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
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

    

    function statusAlert(value) {
        swal.fire({
            text: value + "  variation is still not ready for use. Please specify information and request data/model from Simreka team to enable use",
            confirmButtonText: 'Close',
            confirmButtonClass: 'btn btn-sm btn-danger',
            width: '350px',
            height: '10px',
            icon: 'warning',
        });
        return false;
    }

    function deleteVaration(id) {
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
                    url: "{{ url('/experiment/variation/deleteVartion') }}",
                    method: 'POST',
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
                            title: "Experiment Varation Deleted",
                        })
                        $('#configuration_view_tab').trigger('click')
                        $('#expprofileSpinner').hide();
                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Experiment Varation Deleted .',
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

    function bulkdelVartion() {
        var len = $("[name='select_all_variation[]']:checked").length;
        if (len == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        var values = $("input[name='select_all_variation[]']:checked")
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
                    url: "{{ url('/experiment/variation/bulkdelvariation') }}",
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

    function getVariationView(varid, expid) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_varition') }}",
            method: 'POST',
            data: {
                id: varid,
                process_experiment_id: process_experiment_id,
                viewflag: viewflag

            },
            success: function(result) {
                $('#view_config_data').html('');
                $('#view_config_data').html(result.html);
                $('#expprofileSpinner').hide();
                $('#profilebread').html("Experiment Variation - " + vartion_name);
            }
        });
    }
    $(".deletebulk_configuration").hide();
    $("#example-select-all_variation").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_configuration").show();
        } else {
            $(".deletebulk_configuration").hide();
        }
        $('.checkSingle_variation').not(this).prop('checked', this.checked);
        $('.checkSingle_variation').click(function() {

            if ($('.checkSingle_variation: checked ').length == $('.checkSingle_variation').length) {
                $('#example-select-all_variation').prop('checked', true);
            } else {
                $('#example-select-all_variation').prop('checked', false);
            }
        });
    });
    $('.checkSingle_variation').click(function() {
        var len = $("[name='select_all_variation[]']:checked").length;

        if (len > 1) {
            $(".deletebulk_configuration").show();
        } else {
            $(".deletebulk_configuration").hide();
        }
        if (len == $('.checkSingle_variation').length) {
            $('#example-select-all_variation').prop('checked', true);
        } else {
            $('#example-select-all_variation').prop('checked', false);
        }
    });
</script>