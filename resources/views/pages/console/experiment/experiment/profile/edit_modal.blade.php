@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

@endpush
<div class="modal fade pd " tabindex="-1" role="dialog" aria-labelledby="pd" aria-hidden="true" id="pd1">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="exampleModalLabel">Edit Process Stream
                    </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="process_experiment_name">Process Stream Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Process Stream Name"></i></span>
                        </label>
                        <input type="text" value="{{$data['processDiagram']['name']}}" class="form-control" id="process_stream_name_edit" name="process_stream_name_edit" onchange="$('#process_stream_name_edit-error').hide()" required placeholder="Enter Stream Name">
                        <span class="text-danger" id="process_stream_name_edit-error" style="display:none">Process stream name field is required</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="chemical">Select Stream Flow Type
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Stream Flow Type"></i></span>
                        </label>
                        <select class="form-control" id="process_flowtuye_edit" onchange="editenbleopenstream(this.value);$('#process_flowtuye_edit-error').hide()">
                            <option value="0">Select Stream Flow Type</option>
                            @if(!empty($data['mass_flow_types']))
                            @foreach($data['mass_flow_types'] as $flowkey=>$flowval)
                            @if($data['processDiagram']['flowtype'] == $flowval['id'] )
                            <option selected value="{{___encrypt($flowval['id'])}}">{{$flowval['name']}}</option>
                            @else
                            <option value="{{___encrypt($flowval['id'])}}">{{$flowval['name']}}</option>
                            @endif
                            @endforeach
                            @else
                            @endif
                        </select>
                        <span class="text-danger" id="process_flowtuye_edit-error" style="display:none">Flow type field is required</span>
                    </div>
                    <div class="form-group col-md-4">
                        <br>
                        <br>
                        <div class="custom-control custom-switch ">&nbsp;&nbsp;
                            <?php
                            if ($data['processDiagram']['openstream'] == 1) {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                            <input type="checkbox" class="custom-control-input chkedit" {{$checked}} id="openstream_edit">
                            <label class="custom-control-label text-center" for="openstream_edit">Open Stream</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 card  fromunitedit" style="display: ''">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                            <div>
                                <h6>From Unit</h6> &nbsp;&nbsp;
                            </div>
                            <div>
                                <button id="fromidedit" type="button" class="close float-left" data-toggle="tooltip" data-placement="top" title="Deselect">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-row card-body ">
                            <div class="form-group col-md-6">
                                <label for="">Select Experiment unit
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment unit"></i></span>
                                </label>
                                <select class="form-control" id="experimentunit_output_edit" onchange="getStreamDataInputOutputedit(this.value,'output');$('#experimentunit_output_edit-error').hide()">
                                    <option value="0">Select Experiment Unit</option>
                                    @if(!empty($data['experiment_units']))
                                    @foreach($data['experiment_units'] as $experiment_unit)
                                    @if(!empty($data['processDiagram']['from_unit']['experiment_unit_id']) && $data['processDiagram']['from_unit']['experiment_unit_id'] == $experiment_unit['id'])
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
                                <span class="text-danger" id="experimentunit_output_edit-error" style="display:none">Experiment unit field is required</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Select Stream Detail for Flowtype Output
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Stream Detail for Flowtype Input"></i></span>
                                </label>
                                <select id="outputflowlist_edit">
                                    @if(!empty($data['processDiagram']['from_unit']['output_stream']))
                                    <option value="{{$data['processDiagram']['from_unit']['output_stream']}}">
                                        {{$data['processDiagram']['from_unit']['output_stream']}}
                                    </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 card tounitedit">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                            <div>
                                <h6>To Unit</h6>
                            </div>
                            <div>
                                <button id="toidedit" type="button" class="close float-left" data-toggle="tooltip" data-placement="top" title="Deselect">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-row card-body">
                            <div class="form-group col-md-6 ">
                                <label for="chemical">Select Experiment Unit
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                                </label>
                                <select class="form-control" id="experimentunit_input_edit" onchange="getStreamDataInputOutputedit(this.value,'input');$('#experimentunit_input_edit-error').hide()">
                                    <option value="0">Select Experiment Unit</option>
                                    @if(!empty($data['experiment_units']))
                                    @foreach($data['experiment_units'] as $experiment_unit)
                                    @if(!empty($data['processDiagram']['to_unit']['experiment_unit_id']) && ($data['processDiagram']['to_unit']['experiment_unit_id']) == ($experiment_unit['id']))
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
                                <span class="text-danger" id="experimentunit_input_edit-error" style="display:none">Experiment unit field is required</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Select Stream Detail for Flowtype Input
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Stream Detail for Flowtype Input"></i></span>
                                </label>
                                <select class="form-control" id="inputflowlist_edit">
                                    <option value="">Select Stream Detail for Flowtype Input</option>
                                    @if(!empty($data['processDiagram']['to_unit']['input_stream']))
                                    <option value="{{$data['processDiagram']['to_unit']['input_stream_id']}}">
                                        {{$data['processDiagram']['to_unit']['input_stream']}}
                                    </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 card product">
                        <label class="control-label"><input type="checkbox" id="checkall" title="SelectAll">
                            Select Product List
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Products"></i></span>
                        </label>
                        <select multiple class="js-example-basic-multiple"  id="edit_productid" name="edit_productid[]" multiple=multiple onchange="$('#productid_edit-error').hide()">
                        @if(!empty($data['products']))
                        @foreach($data['products'] as $product)
                        @if(!empty($data['processDiagram']['products']) && in_array($product['id'],$data['processDiagram']['products']))
                        <option selected value="{{___encrypt($product['id'])}}">{{$product['name']}}</option>
                        @else
                        <option value="{{___encrypt($product['id'])}}">{{$product['name']}}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                    <br>


                    <span class="text-danger" id="productid_edit-error" style="display:none">Product field is required</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="updateprocessDiagram()" class="btn btn-sm btn-secondary submit">Submit</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>


@endpush

{{-- <script>
    // In your Javascript
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
      $('#edit_productid').select2();

      $('#checkall').click(function(){
          if($("#checkall").is(':checked')){
              $("#edit_productid > option").prop("selected","selected");
              $("#edit_productid").trigger("change");
          } else {
              $("#edit_productid > option").prop("selected",false);
              $("#edit_productid").trigger("change");
          }
      });
    });
    </script>
<script>
//    $('#checkbox').click(function() {
//     // From the other examples
//     if (this.checked) {
//         $("select > option").prop("selected",true).value
//     }else{
//         $("select > option").prop("selected",false).value
//      }
// });





$("#button").click(function(){
       alert($("select").val());
});
    $("select.form-control").addClass("js-example-basic-single");
     $("select.form-control").css("width",'100%');
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();


        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });
    var condition = "{{$data['processDiagram']['flowtype']}}";
    var expiito = "{{(!empty($data['processDiagram']['to_unit']['experiment_unit_id']))?___encrypt($data['processDiagram']['to_unit']['experiment_unit_id']):0}}";
    var expiifrom = "{{(!empty($data['processDiagram']['from_unit']['experiment_unit_id']))?___encrypt($data['processDiagram']['from_unit']['experiment_unit_id']):0}}";
    var inputstreamid = "{{(!empty($data['processDiagram']['to_unit']['input_stream_id']))?$data['processDiagram']['to_unit']['input_stream_id']:0}}";
    var inputstream = "{{(!empty($data['processDiagram']['to_unit']['input_stream']))?$data['processDiagram']['to_unit']['input_stream']:''}}";

    var outputstreamid = "{{(!empty($data['processDiagram']['from_unit']['output_stream_id']))?$data['processDiagram']['from_unit']['output_stream_id']:0}}";
    var outputstream = "{{(!empty($data['processDiagram']['from_unit']['output_stream']))?$data['processDiagram']['from_unit']['output_stream']:''}}";

    $('#fromidedit').click(function() {
        $(".tounitedit").css("display", "");
        $(".fromunitedit").css("display", "");
        $('#experimentunit_input_edit').val(0);
        $('#experimentunit_output_edit').val(0);
        $('#outputflowlist_edit').html('');
        $('#inputflowlist_edit').html('');
    });

    $('#toidedit').click(function() {
        $(".tounitedit").css("display", "");
        $(".fromunitedit").css("display", "");
        $('#experimentunit_input_edit').val(0);
        $('#experimentunit_output_edit').val(0);
        $('#outputflowlist_edit').html('');
        $('#inputflowlist_edit').html('');
    });
    if (expiito != 0) {
        getStreamDataInputOutputedit(expiito, 'input');
        $(".product").css("display", "");
    }
    if (expiifrom != 0) {
        getStreamDataInputOutputedit(expiifrom, 'output');
        $(".product").css("display", "none");
    }

    function getStreamDataInputOutputedit(value, type) {

        if (type == "input") {
            if (value != 0 && $('#openstream_edit').is(':checked')) {
                $('#experimentunit_output_edit').val(0);
                $('#outputflowlist_edit').html('');
                $(".fromunitedit").css("display", "none");
            } else {
                $(".fromunitedit").css("display", "");
            }
        }
        if (type == "output") {
            if (value != 0 && $('#openstream_edit').is(':checked')) {
                $('#experimentunit_input_edit').val(0);
                $('#inputflowlist_edit').html('');
                $(".tounitedit").css("display", "none");
            } else {
                $(".tounitedit").css("display", "");
            }
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/getstreamdata/') }}",
            method: 'GET',
            data: {
                experiment_unit_id: value,
                process_experiment_id: process_experiment_id,
                tab: type,
                vartion_id: vartion_id,
                flag: 'edit',
                expiito: expiito,
                expiifrom: expiifrom,
                inputstreamid: inputstreamid,
                inputstream: inputstream,
                outputstreamid: outputstreamid,
                outputstream: outputstream

            },
            success: function(result) {
                obj = JSON.parse(result);
                objcnt = Object.keys(obj.streams).length;
                if (obj.flowtype == "input") {
                    $('#inputflowlist_edit').html('');
                    var html = "";
                    if (objcnt != 0) {
                        for (i in obj.streams) {
                            html += '<option value="' + obj.streams[i]['input_stream_id'] + '">';
                            html += obj.streams[i]['stream_name'];
                            html += '</option>';
                        }
                    } else {
                        html += '<option value="0">';
                        html += "No Streams Found";
                        html += '</option>';
                    }
                    $('#inputflowlist_edit').html(html);
                }
                if (obj.flowtype == "output") {
                    var htmloutput = "";
                    if (objcnt != 0) {
                        for (x in obj.streams) {
                            htmloutput += '<option value="' + obj.streams[x]['output_stream_id'] + '">';
                            htmloutput += obj.streams[x]['stream_name'];
                            htmloutput += '</option>';
                        }
                    } else {
                        htmloutput += '<option value="0">';
                        htmloutput += "No Streams Found";
                        htmloutput += '</option>';
                    }
                    $('#outputflowlist_edit').html(htmloutput);
                }
            }
        })
    }

    $('#openstream_edit').click(function() {
        if ($('#openstream_edit').is(':checked')) {} else {
            $(".tounitedit").css("display", "");
            $(".fromunitedit").css("display", "");
            $('#experimentunit_input_edit').val(0);
            $('#experimentunit_output_edit').val(0);
            $('#outputflowlist_edit').html('');
            $('#inputflowlist_edit').html('');
        }
    })

    function editenbleopenstream(value) {

        if (value == "VolejRejNm" || value == "Wpmbk5ezJn" || value == "k8mep2bMyJ") {
            $('#experimentunit_output_edit').val(0);
            $('#outputflowlist_edit').html('');
            $(".fromunitedit").css("display", "none");

            $('#experimentunit_input_edit').val(0);
            $('#inputflowlist_edit').html('');
            $(".tounitedit").css("display", "");
            $(".product").css("display", "");
            $('#edit_productid').val('').trigger("change");
        } else if (value == "Opnel5aKBz" || value == "wMvbmOeYAl" || value == "4openRe7Az" || value == "yMYerEdOBQ") {
            $('#experimentunit_input_edit').val(0);
            $('#inputflowlist_edit').html('');
            $(".tounitedit").css("display", "none");

            $('#experimentunit_output_edit').val(0);
            $('#outputflowlist_edit').html('');
            $(".fromunitedit").css("display", "");
            $(".product").css("display", "none");
            $('#edit_productid').val('').trigger("change");
        } else {
            $('#experimentunit_input_edit').val(0);
            $('#inputflowlist_edit').html('');
            $(".tounitedit").css("display", "");
            $('#experimentunit_output_edit').val(0);
            $('#outputflowlist_edit').html('');
            $(".fromunitedit").css("display", "");
            $(".product").css("display", "none");
            $('#edit_productid').val('').trigger("change");
        }

        if (value == "l4zbq2dprO" || value == "WJxbojagwO") {
            document.getElementById("openstream_edit").checked = false;
        } else {
            document.getElementById("openstream_edit").checked = true;
        }
    }

    function updateprocessDiagram() {
        if (process_experiment_id != "") {
            var processDiagramId = '<?php echo $data['processDiagram']['id'] ?>';
            var process_stream_name = $('#process_stream_name_edit').val();
            var mass_flow_type_id = $('#process_flowtuye_edit').val();
            var experimentunit_input = $('#experimentunit_input_edit').val();
            var experimentunit_output = $('#experimentunit_output_edit').val();
            var openstream = 0;
            if (document.getElementById("openstream_edit").checked == true) {
                openstream = 1;
            } else {
                openstream = 0;
            }
            var inputstreamvalue = $('#inputflowlist_edit').val();
            var outputstreamvalue = $('#outputflowlist_edit').val();
            var inputstreamtext = $("#inputflowlist_edit option:selected").text();
            var outputstreamtext = $("#outputflowlist_edit option:selected").text();
            var products = $("select[name='edit_productid[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();
            if (process_stream_name == "") {
                $('#process_stream_name_edit-error').show();
                return false;
            }
            if (mass_flow_type_id == 0) {
                $('#process_flowtuye_edit-error').show();
                return false;
            }
            if (mass_flow_type_id == "VolejRejNm" || mass_flow_type_id == "Wpmbk5ezJn" || mass_flow_type_id == "k8mep2bMyJ") {
                if(experimentunit_input==0){
                    $('#experimentunit_input_edit-error').show();
                    return false;
                }
                if(products==""){
                    $('#productid_edit-error').show();
                    return false;
                }
            } else if (mass_flow_type_id == "Opnel5aKBz" || mass_flow_type_id == "wMvbmOeYAl" || mass_flow_type_id == "4openRe7Az" || mass_flow_type_id == "yMYerEdOBQ") {
                if(experimentunit_output==0){
                    $('#experimentunit_output_edit-error').show();
                    return false;
                }
            } else {
                if(experimentunit_input==0){
                    $('#experimentunit_input_edit-error').show();
                    return false;
                }
                if(experimentunit_output==0){
                    $('#experimentunit_output_edit-error').show();
                    return false;
                }
            }
            if ($("#experimentunit_input_edit option:selected").text()) {
                var experimentunit_input_text = $("#experimentunit_input_edit option:selected").text();
            } else {
                var experimentunit_input_text = "";
            }
            if ($("#experimentunit_output_edit option:selected").text()) {
                var experimentunit_output_text = $("#experimentunit_output_edit option:selected").text();
            } else {
                var experimentunit_output_text = "";
            }
            var objectexp_edit = {
                "tab": "process_diagram",
                "process_experiment_id": process_experiment_id,
                "process_stream_name": process_stream_name,
                "experimentunit_input": experimentunit_input,
                "experimentunit_output": experimentunit_output,
                "mass_flow_type_id": mass_flow_type_id,
                "inputstreamvalue": inputstreamvalue,
                "outputstreamvalue": outputstreamvalue,
                "inputstreamtext": inputstreamtext,
                "outputstreamtext": outputstreamtext,
                "openstream": openstream,
                "experimentunit_input_text": experimentunit_input_text,
                "experimentunit_output_text": experimentunit_output_text,
                "processDiagramId": processDiagramId,
                "products":products
            };
            url = '{{ url("/experiment/process_diagram/update")}}';
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify(objectexp_edit),
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
                    $(".pd").modal('hide');
                    $('#process_stream_name_edit').val('');
                    $('#experimentunit_input_edit').val(0);
                    $('#experimentunit_output_edit').val(0);
                    document.getElementById("openstream_edit").checked = false;
                    $('#outputflowlist_edit').html('');
                    $('#inputflowlist_edit').html('');
                    $(".tounitedit").css("display", "");
                    $(".fromunitedit").css("display", "");
                    getDiagram();
                    $("#process_flow_table_tab").addClass("show active");
                },
            });
        }
    }

</script>
