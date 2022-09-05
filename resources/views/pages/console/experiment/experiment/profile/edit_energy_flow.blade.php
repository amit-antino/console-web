<div class="modal fade ef " tabindex="-1" role="dialog" aria-labelledby="ef" aria-hidden="true" id="ef{{$data['id']}}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Energy Flow</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="process_experiment_name">Energy Stream Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy Stream Name"></i></span>
                            </label>
                            <input type="text" value="{{$data['processEnergyFlow']['stream_name']}}" class="form-control" id="energy_stream_name_edit" name="energy_stream_name_edit" required placeholder="Enter Energy Stream Name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Select Energy Utility
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Energy Utility"></i></span>
                            </label>
                            <select class="form-control" id="utility_id_edit">
                                <option value="0">Select Energy Utility</option>
                                @if(!empty($data['selectUtilityArr']))
                                @foreach($data['selectUtilityArr'] as $selectUtilityval)
                                @if($data['processEnergyFlow']['energy_utility_id'] == $selectUtilityval['id'])
                                <option selected value="{{___encrypt($selectUtilityval['id'])}}">
                                    {{$selectUtilityval['energy_name']}}
                                </option>
                                @else
                                <option value="{{___encrypt($selectUtilityval['id'])}}">
                                    {{$selectUtilityval['energy_name']}}
                                </option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <br>
                            <br>
                            <div class="custom-control custom-switch ">&nbsp;&nbsp;
                                <?php
                                if ($data['processEnergyFlow']['input_output'] == 1) {
                                    $checked = "checked";
                                } else {
                                    $checked = "";
                                }
                                ?>
                                <input type="checkbox" class="custom-control-input " {{$checked }} id="inputoutput_edit">
                                <label class="custom-control-label text-center" for="inputoutput_edit">&nbsp;&nbsp;<span id="ioenenrgy_edit">Input</span></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="chemical">Select Experiment Unit
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                            </label>
                            <select class="form-control" id="energy_experimentunit_id_edit">
                                <option value="0">Select Experiment Unit</option>
                                @if(!empty($data['experiment_units']))
                                @foreach($data['experiment_units'] as $experiment_unit)
                                @if($data['processEnergyFlow']['experiment_unit_id'] == $experiment_unit['id'])
                                <option selected value="{{___encrypt($experiment_unit['id'])}}">
                                    {{$experiment_unit['experiment_unit_name']}}
                                </option>
                                @else
                                <option value="{{___encrypt($experiment_unit['id'])}}">
                                    {{$experiment_unit['experiment_unit_name']}}
                                </option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="chemical">Select Stream Flow Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Stream Flow Type"></i></span>
                            </label>
                            <select class="form-control" id="energy_flow_type_edit">
                                <option value="0">Select Stream Flow Type </option>
                                @if(!empty($data['flowTypeEnergy']))
                                @foreach($data['flowTypeEnergy'] as $energyflowkey=>$energyflowval)
                                @if($data['processEnergyFlow']['stream_flowtype'] == $energyflowval['id'])
                                <option selected value="{{___encrypt($energyflowval['id'])}}">
                                    {{$energyflowval['flow_type_name']}}
                                </option>
                                @else
                                <option value="{{___encrypt($energyflowval['id'])}}">
                                    {{$energyflowval['flow_type_name']}}
                                </option>
                                @endif
                                @endforeach
                                @else
                                <option value="0">No Stream Flow Type found</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="updateenergyflow()" class="btn btn-sm btn-secondary submit">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#inputoutput_edit').click(function() {
        if ($('#inputoutput_edit').is(':checked')) {
            $('#ioenenrgy_edit').html("Output");
        } else {
            $('#ioenenrgy_edit').html("Input");
        }
    });

    function updateenergyflow() {
        if (process_experiment_id != "") {
            var energy_stream_name = $('#energy_stream_name_edit').val();
            var utility_id = $('#utility_id_edit').val();
            var energy_experimentunit_id = $('#energy_experimentunit_id_edit').val();
            var energy_flow_type = $('#energy_flow_type_edit').val();
            var inputoutput = 0;
            if (document.getElementById("inputoutput_edit").checked == true) {
                inputoutput = 1;
            } else {
                inputoutput = 0;
            }
            if (energy_stream_name == "") {
                swal.fire({
                    text: "Please Enter Energy Stream Name",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (energy_experimentunit_id == "0") {
                swal.fire({
                    text: "Please Select From Unit Experiment unit",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (utility_id == "0") {
                swal.fire({
                    text: "Please Select Energy Utility  ",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (energy_flow_type == "0") {
                swal.fire({
                    text: "Please Select Energy FlowType  ",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            var objectexp = {
                "tab": "energyflow",
                "process_experiment_id": process_experiment_id,
                "energy_stream_name": energy_stream_name,
                "utility_id": utility_id,
                "energy_experimentunit_id": energy_experimentunit_id,
                "energy_flow_type": energy_flow_type,
                "inputoutput": inputoutput
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var processEnergyId = '<?php echo ___encrypt($data['
            processEnergyFlow ']['
            id ']) ?>';
            var url = '{{ url("/experiment/process_exp_energflow") }}';
            url += '/' + processEnergyId;
            $.ajax({
                type: 'PUT',
                url: url,
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
                    $(".ef").modal('hide');
                    $('#energy_stream_name_edit').val('');
                    $('#utility_id_edit').val(0);
                    $('#energy_flow_type_edit').val(0);
                    document.getElementById("inputoutput_edit").checked = false;
                    $('#energy_experimentunit_id_edit').val(0);
                    getEnergyList();
                    $(".ef").modal('hide');
                    $("#energy_flow_tab").addClass("show active");
                },
            });
        }
    }
</script>