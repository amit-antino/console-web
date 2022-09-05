<div class="table-responsive">
    <table id="process_diagram_table" class="table">
        <thead>
            <tr>
                @if($process_experiment_info['viewflag']!="view")
                <th class="text-center align-middle" rowspan="2" >
                    <input type="checkbox" id="example-select-all_diagram">
                </th>
                @endif
                <th class="text-center align-middle" rowspan="2">No</th>
                <th class="text-center align-middle" rowspan="2">Stream Name</th>
                <th class="text-center align-middle" rowspan="2">Flow type</th>
                <th class="text-center" colspan="2">From Unit</th>
                <th class="text-center" colspan="2">To Unit</th>
                <th class="text-center align-middle"  rowspan="2">Products</th>
                @if($process_experiment_info['viewflag']!="view")
                <th class=" text-center align-middle" rowspan="2">Actions</th>
                @endif
            </tr>
            <tr>
                <th class="text-center">Experiment Unit</th>
                <th class="text-center"> Experiment Stream</th>
                <th class="text-center">Experiment Unit</th>
                <th class="text-center"> Experiment Stream </th>
            </tr>
        </thead >
        <tbody class="font-weight-normal">
            <input type="hidden" id="variation_id" name="variation_id" value="{{$process_experiment_info['variation_id']}}">
            @php
                $per = request()->get('sub_menu_permission');
                $permission=!empty($per['process_flow_table']['method'])?$per['process_flow_table']['method']:[];
            @endphp
            @if(!empty($process_experiment_info['processDiagramArr']))
            @foreach($process_experiment_info['processDiagramArr'] as $process_diagram_key =>$process_diagram_value)
            <tr style="width:100px">
                @if($process_experiment_info['viewflag']!="view")
                <td><input type="checkbox" value="{{___encrypt($process_diagram_value['id'])}}" class="checkSingle_diagram" name="select_all_diagram[]"></td>
                @endif
                <td class="text-wrap width-100">{{$process_diagram_key+1}}</td>
                <td>
                    {{$process_diagram_value['name']}}
                    @if($process_diagram_value['openstream']==1)
                    <br> <span class="badge badge-info">
                        Open Stream
                    </span>
                    @endif
                </td>
                <td>
                    @if(!empty($process_experiment_info['mass_flow_types']))
                    @foreach($process_experiment_info['mass_flow_types'] as $flowkey=>$flowval)
                    @if($process_diagram_value['flowtype'] == $flowval['id'] )
                    <span> {{$flowval['name']}}</span>
                    @endif
                    @endforeach
                    @endif
                </td>
                <td class="text-wrap width-200">
                    @if(!empty($process_diagram_value['from_unit']['experiment_unit_id']))
                    {{getExpUnitname($process_diagram_value['process_id'],$process_diagram_value['from_unit']['experiment_unit_id'])}}
                    @endif
                </td>
                <td class="text-wrap width-200">
                    @if(!empty($process_diagram_value['from_unit']['output_stream']))
                    {{$process_diagram_value['from_unit']['output_stream']}}
                    @endif
                </td>
                <td class="text-wrap width-200">
                    @if(!empty($process_diagram_value['to_unit']['experiment_unit_name']))
                    {{getExpUnitname($process_diagram_value['process_id'],$process_diagram_value['to_unit']['experiment_unit_id'])}}
                    @endif
                </td>
                <td class="text-wrap width-200">@if(!empty($process_diagram_value['to_unit']['input_stream']))
                    {{$process_diagram_value['to_unit']['input_stream']}}
                    @endif
                </td>

                <td class="d-flex justify-content-center" id="roww">
                    @if(!empty($process_diagram_value['products']))
                    @foreach($process_diagram_value['products'] as $product)




                    <div class="border">

                    <span class="badge badge-info" >

                               {{getsingleChemicalName($product)}}



                     </span>

                    </div>


                    @endforeach

                @endif

                </div>
                </td>
                </div>


                @if($process_experiment_info['viewflag']!="view")
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <!-- <a href="javascript:void(0);" data-url="{{url('/experiment/process_diagram/'.___encrypt($process_diagram_value['id']).'/edit')}}" data-request="ajax-popup" data-target="#editprocessdiagram" data-tab="#pd{{$process_diagram_value['id']}}" type="type" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Data">
                            <i class="fas fa-edit text-secondary"></i>
                        </a> -->
                        @php
                        $pidd=___encrypt($process_diagram_value['id']);
                        @endphp
                        @if(in_array('edit',$permission))
                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Data" onclick="editdigram('{{$pidd}}')" >
                            <i class="fas fa-edit text-secondary"></i>
                        </a>
                        @endif
                        @if(in_array('delete',$permission))
                        <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="deleteprocessDiagram('{{$pidd}}')" >
                            <i class="fas fa-trash text-secondary"></i>
                        </a>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Record Found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<script>
       $("#checkbox").click(function(){
    if($("#checkbox").is(':checked') ){
        $("select > option").prop("selected","selected");
    }else{
        $("select > option").removeAttr("selected");
     }
});
    function deleteprocessDiagram(id) {
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
                    url: "{{ url('/experiment/process_diagram/deleteDiagram') }}",
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
                            title: " Deleted",
                        })
                        $('#process_flow_table_tab').trigger('click')
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
                $('#process_flow_table_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })




    }

    function bulkdelDiagram() {
        var len = $("[name='select_all_diagram[]']:checked").length;
        if (len == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        var values = $("input[name='select_all_diagram[]']:checked")
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
                    url: "{{ url('/experiment/process_diagram/bulkdelDiagram') }}",
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
                        $('#process_flow_table_tab').trigger('click')
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
                $('#process_flow_table_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })


    }
    //cntpd = "{{count($process_experiment_info['processDiagramArr'])}}";
    cntpd=0;
    if (cntpd > 10)

        $(function() {
            'use strict';
            $('#process_diagram_table').DataTable({
                "iDisplayLength": 100,

                "language": {
                    search: ""
                }
            });
            $('#process_diagram_table').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        });
    $("#example-select-all_en").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_en").show();
        } else {
            $(".deletebulk_en").hide();
        }
        $('.checkSingle_en').not(this).prop('checked', this.checked);
        $('.checkSingle_en').click(function() {
            if ($('.checkSingle_en: checked ').length == $('.checkSingle_en').length) {
                $('#example-select-all_en').prop('checked', true);
            } else {
                $('#example-select-all_en').prop('checked', false);
            }
        });
    });
    $('.checkSingle_en').click(function() {
        var len = $("[name='select_all_en[]']:checked").length;
        if (len >= 1) {
            $(".deletebulk_en").show();
        } else {
            $(".deletebulk_en").hide();
        }
    });

    function editdigram(id) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{url("/experiment/process_diagram/edit") }}',
            method: 'post',
            data: {
                id: id
            },

            success: function(result) {
                $("#editprocessdiagram").html(result.html);
                $('#expprofileSpinner').hide();
                $("#pd" + 1).modal('show');

            }
        });
    }
    $("#example-select-all_diagram").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_diagram").show();
        } else {
            $(".deletebulk_diagram").hide();
        }
        $('.checkSingle_diagram').not(this).prop('checked', this.checked);
        $('.checkSingle_diagram').click(function() {
            if ($('.checkSingle_diagram: checked ').length == $('.checkSingle_diagram')
                .length) {
                $('#example-select-all_diagram').prop('checked', true);
            } else {
                $('#example-select-all_diagram').prop('checked', false);
            }
        });
    });
    $('.checkSingle_diagram').click(function() {
        var len = $("[name='select_all_diagram[]']:checked").length;
        if (len > 1) {
            $(".deletebulk_diagram").show();
        } else {
            $(".deletebulk_diagram").hide();
        }
        if (len == $('.checkSingle_diagram').length) {
            $('#example-select-all_diagram').prop('checked', true);
        } else {
            $('#example-select-all_diagram').prop('checked', false);
        }
    });
</script>
