@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

<div class="tab-pane fade show active" id="v-expdata" role="tabpanel" aria-labelledby="v-expdata-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Experiment Unit Specification -
                            {{$data['experiment_units']['experiment_equipment_unit']['experiment_unit_name']}}
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="condition"><input type="checkbox" id=checkall title="SelectAll"> Select Conditions
                            <span>
                                <i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i>
                            </span>
                        </label>
                        <select class="js-example-basic-multiple" id="conditionid" name="conditionid[]" multiple="multiple">
                            @if(empty($data['condition_list']))
                            @if(!empty($data['master_condition_list']))
                            @foreach($data['master_condition_list'] as $condition)
                            @if(in_array($condition['id'],$data['condition_list']))
                            <option selected value="{{___encrypt($condition['id'])}}">{{$condition['name']}}</option>
                            @else
                            <option value="{{___encrypt($condition['id'])}}">{{$condition['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                            @else
                            @if(!empty($data['master_condition_list']))
                            @foreach($data['master_condition_list'] as $condition)
                            @if(in_array($condition['id'],$data['condition_list']))
                            <option selected value="{{___encrypt($condition['id'])}}">{{$condition['name']}}</option>
                            @else
                            <option value="{{___encrypt($condition['id'])}}">{{$condition['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                            @endif
                        </select>
                    </div>
                    <input type="hidden" name="variation_id" id="variation_id" value="{{!empty($data['variation_id'])?$data['variation_id']:''}}">
                    <div class="form-group col-md-4">
                        <label for="outcome"> <input type="checkbox" id="chkall" title="SelectAll"> Select Outcomes
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcomes"></i></span>
                        </label>
                        <select class="js-example-basic-multiple" name="outcomeid[]" id="outcomeid" multiple="multiple">
                            @if(empty($data['outcome_list']))
                            @if(!empty($data['master_outcome_list']))
                            @foreach($data['master_outcome_list'] as $outcome)
                            @if(in_array($outcome['id'],$data['outcome_list']))
                            <option selected value="{{___encrypt($outcome['id'])}}">{{$outcome['name']}}</option>
                            @else
                            <option value="{{___encrypt($outcome['id'])}}">{{$outcome['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                            @else
                            @if(!empty($data['master_outcome_list']))
                            @foreach($data['master_outcome_list'] as $outcome)
                            @if(in_array($outcome['id'],$data['outcome_list']))
                            <option selected value="{{___encrypt($outcome['id'])}}">{{$outcome['name']}}</option>
                            @else
                            <option value="{{___encrypt($outcome['id'])}}">{{$outcome['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="outcome"> Select Reaction
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reaction"></i></span>
                        </label>
                        <select class="js-example-basic-multiple" name="reactionid[]" id="reactionid" multiple="multiple">
                            @if(!empty($data['reaction_list']))
                            @foreach($data['reaction_list'] as $rk=>$rv)
                            @if(in_array($rv['id'],$data['reactions']))
                            <option selected value="{{___encrypt($rv['id'])}}">{{$rv['name']}}</option>
                            @else
                            <option value="{{___encrypt($rv['id'])}}">{{$rv['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- <div class="card-footer text-right">
                    <button type="button" onclick="productCondition()" class="btn btn-sm btn-secondary submit">Submit</button>
                    <button type="reset" class="btn btn-danger btn-sm">Cancel</button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<div id="edit-div"></div>
<div id="edit-div-condition"></div>
<div id="add-div-condition"></div>
<div id="edit-div-outcome"></div>
<div id="add-div-outcome"></div>

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush
<script type="text/javascript">
    $(document).ready(function() {
        $('#conditionid').select2();

        $("#checkall").click(function(){
            if($("#checkall").is(':checked')){
                $("#conditionid > option").prop("selected", "selected");
                $("#conditionid").trigger("change");
            } else {
                $("#conditionid > option").prop("selected", false);
                $("#conditionid").trigger("change");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#outcomeid').select2();

            $("#chkall").click(function(){
                if($("#chkall").is(':checked')){
                    $("#outcomeid > option").prop("selected", "selected");
                    $("#outcomeid").trigger("change");
                } else {
                    $("#outcomeid > option").prop("selected", false);
                    $("#outcomeid").trigger("change");
                }
            });
        });
        </script>
<script>
    $('#productIO').DataTable();
    $(function() {
        if (viewflag != "view") {
            if ($(".js-example-basic-single").length) {
                $(".js-example-basic-single").select2();
            }

            if ($(".js-example-basic-multiple").length) {
                $(".js-example-basic-multiple").select2();
            }
        } else {
            $(".js-example-basic-single").select2().prop('disabled', true);;
            $(".js-example-basic-multiple").select2().prop('disabled', true);;
        }
    });

    function removeRowcon(cnt) {
        $("#inputFormRowcon" + cnt).remove();
    }

    // remove row
    function removeRowoutcome(cnt) {
        $("#exp_out_inputFormRow" + cnt).remove();
    }
    // remove row reaction_eqution
    function reaction_removeRow(cnt) {
        $("#reaction_inputFormRow" + cnt).remove();
    }

    function getconditionunit(value, cnt) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('experiment/experiment/getConditionunit') }}",
            method: 'POST',
            data: {
                value: value,
                type: "condition"
            },
            success: function(result) {
                unitObj = JSON.parse(result);
                var unitname = unitObj['unitname'];
                var unit = unitObj['masterUnit'];
                var htmlunitname = "";
                for (i in unitname) {
                    htmlunitname += "<option class='unit'  selected value=" + i + ">" + unitname[i] +
                        "</option>";
                }
                var htmlunit = "";
                for (i in unit) {
                    htmlunit += "<option class='unit'  selected value=" + i + ">" + unit[i] + "</option>";
                }
                $('#unitConditon' + cnt).html(htmlunit);
                $('#unit_typecondition' + cnt).html(htmlunitname);
            }
        });
    }
    // remove row

    function getoutcomeunit(value, cnt) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('experiment/experiment/getConditionunit') }}",
            method: 'POST',
            data: {
                value: value,
                type: "outcome"
            },
            success: function(result) {
                unitObj = JSON.parse(result);
                var unitname = unitObj['unitname'];
                var unit = unitObj['masterUnit'];
                var htmlunitname = "";
                for (i in unitname) {
                    htmlunitname += "<option class='unit'  selected value=" + i + ">" + unitname[i] +
                        "</option>";
                }
                var htmlunit = "";
                for (i in unit) {
                    htmlunit += "<option class='unit'  selected value=" + i + ">" + unit[i] + "</option>";
                }
                $('#exp_out_unit' + cnt).html(htmlunit);
                $('#exp_out_ut' + cnt).html(htmlunitname);
            }
        });
    }

    function productCondition() {
        var experiment_unit_id = '<?php echo $data['unit_tab_id']; ?>';
        if (process_experiment_id != "") {
            var conditions = [];
            var conditionid = $('#conditionid').val();
            var variation_id = $('#variation_id').val();
            var outcomeid = $('#outcomeid').val();
            var reactionid = $('#reactionid').val();
            var objectexp = {
                "process_experiment_id": process_experiment_id,
                "experiment_unit_id": experiment_unit_id,
                "variation_id": variation_id,
                "tab": "condition",
                "conditions": conditionid,
                "outcome": outcomeid,
                "reaction": reactionid,
                "vartion_id": vartion_id
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experimentProfile/saveprofile") }}',
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
                },
            });
        }
    }

    $('#master').click(function() {
        if ($('#master').is(':checked')) {
            //input where you put a value
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You Want to Add it to Master Data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'ml-2',
                confirmButtonText: 'Yes, Add it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    swalWithBootstrapButtons.fire(
                        'Added!',
                        ' Master Data Added .',
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
                    document.getElementById("master").checked = false;
                }
            })
        } else {
            document.getElementById("master").checked = false;
        }
    });
</script>
