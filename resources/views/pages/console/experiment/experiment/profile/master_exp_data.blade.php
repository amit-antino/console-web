@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
<div class="tab-pane fade show active" id="v-expdata" role="tabpanel" aria-labelledby="v-expdata-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="condition"><input type="checkbox" id="chkall" style="text-indent: 0em" tooltip="Select all"> Select Conditions
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i></span>
                        </label>
                        <select class="js-example-basic-multiple" id="condition_masterid" name="condition_masterid[]" multiple="multiple">
                            @if(!empty($data['master_condition_list']))
                            @foreach($data['master_condition_list'] as $condition)
                            @if(!empty($data['mastercondition']) && in_array($condition['id'],$data['mastercondition']))
                            <option selected value="{{___encrypt($condition['id'])}}">{{$condition['name']}}</option>
                            @else
                            <option value="{{___encrypt($condition['id'])}}">{{$condition['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <input type="hidden" name="variation_id" id="variation_id" value="{{!empty($data['variation_id'])?$data['variation_id']:''}}">
                    <div class="form-group col-md-4">
                        <label for="outcome"><input type="checkbox" id="checkall">      Select Outcomes
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcomes"></i></span>
                        </label>
                        <select class="js-example-basic-multiple" name="outcome_masterid[]" id="outcome_masterid" multiple="multiple">
                            @if(!empty($data['master_outcome_list']))
                            @foreach($data['master_outcome_list'] as $outcome)
                            @if(!empty($data['masteroutcome']) && in_array($outcome['id'],$data['masteroutcome']))
                            <option selected value="{{___encrypt($outcome['id'])}}">{{$outcome['name']}}</option>
                            @else
                            <option value="{{___encrypt($outcome['id'])}}">{{$outcome['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="outcome">Select Reaction
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcomes"></i></span>
                        </label>
                        <select class="js-example-basic-multiple" name="reaction_masterid[]" id="reaction_masterid" multiple="multiple">
                            @if(!empty($data['reaction_list']))
                            @foreach($data['reaction_list'] as $rk=>$rv)
                            @if(!empty($data['masterreaction']) && in_array($rv['id'],$data['masterreaction']))
                            <option selected value="{{___encrypt($rv['id'])}}">{{$rv['name']}}</option>
                            @else
                            <option value="{{___encrypt($rv['id'])}}">{{$rv['name']}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="edit-div_master"></div>
<div id="edit-div-condition-master"></div>
<div id="add-div-condition-master"></div>
<div id="edit-div-outcome-master-output"></div>
<div id="add-div-outcome-master"></div>

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
@endpush
<script type="text/javascript">
    $(document).ready(function() {
        $('#condition_masterid').select2();

        $("#chkall").click(function(){
            if($("#chkall").is(':checked')){
                $("#condition_masterid > option").prop("selected", "selected");
                $("#condition_masterid").trigger("change");
            } else {
                $("#condition_masterid > option").prop("selected", false);
                $("#condition_masterid").trigger("change");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#outcome_masterid').select2();

            $("#checkall").click(function(){
                if($("#checkall").is(':checked')){
                    $("#outcome_masterid > option").prop("selected", "selected");
                    $("#outcome_masterid").trigger("change");
                } else {
                    $("#outcome_masterid > option").prop("selected", false);
                    $("#outcome_masterid").trigger("change");
                }
            });
        });
        </script>

<script>
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
</script>
