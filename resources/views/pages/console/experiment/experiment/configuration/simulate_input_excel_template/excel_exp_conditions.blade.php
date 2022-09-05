@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
<div class="tab-pane fade show active" id="v-expdata" role="tabpanel" aria-labelledby="v-expdata-tab">
    <div class="table">
        <table id="table-data" class="table">
            <thead>
                <tr>
                    <th>Experiment Unit Name</th>
                    <th>Condition Name</th>
                    <th>Set Default Unit</th>
                    <th>Unit constant</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($data['condition_data']))
                @foreach($data['condition_data'] as $count=>$condition)
                <tr>
                    <td>{{$condition['exp_unit']}}</td>
                    <td>{{$condition['condition']}}</td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$count}}" onclick="set_default({{$count}})" @if($condition['isdefault']==1) checked @endif>
                            <label class="custom-control-label" for="customSwitch{{$count}}"></label>
                        </div>
                    </td>
                    <td class="text-center">
                        <input type="hidden" id="exp_unit{{$count}}" value="{{$condition['exp_unit']}}" />
                        <input type="hidden" id="exp_unit_id{{$count}}" value="{{___encrypt($condition['exp_unit_id'])}}" />
                        <input type="hidden" id="unit_id{{$count}}" value="{{___encrypt($condition['unit_id'])}}" />
                        <input type="hidden" id="condition_id{{$count}}" value="{{___encrypt($condition['id'])}}" />
                        <input type="hidden" id="condition{{$count}}" value="{{$condition['condition']}}" />
                        <input type="hidden" id="default{{$count}}" value="{{___encrypt($condition['default_unit'])}}" />
                        <select name="unit_constant_id" id="unit_constant_list{{$count}}" class="form-control">
                            <option value="">Select Unit Constant</option>
                            @if(!empty($condition['unit_constants']))
                            @foreach($condition['unit_constants'] as $k=>$unit_type)
                            <option @if($condition['selected_unit_constant']==$unit_type['id']) selected @endif value="{{___encrypt($unit_type['id'])}}" data-default_unit="{{!empty(getdefaultUnit($unit_type['id']))}}">{{$unit_type['unit_name']}}</option>
                            @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
                <script>
                    var new_count = "{{$count}}";
                    set_default(new_count)
                </script>
                @endforeach
                @endif
            </tbody>
        </table>
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

<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });

    function save_data() {
        var stream_id = '<?php echo $data['unit_tab_id']; ?>';
        if (experiment_id != "") {
            var row = $('#table-data >tbody >tr').length;
            var arr = [];
            for (i = 0; i < row; i++) {
                isdefault = 0
                if ($("#customSwitch" + i).prop('checked') == true) {
                    isdefault = 1;
                }
                arr[i] = {
                    "id": i,
                    "exp_unit_id": $('#exp_unit_id' + i).val(),
                    "exp_unit": $('#exp_unit' + i).val(),
                    "unitid": $('#unit_id' + i).val(),
                    "conditionid": $('#condition_id' + i).val(),
                    "condition": $('#condition' + i).val(),
                    "isdefault": isdefault,
                    "unit_constant": $('#unit_constant_list' + i).val(),
                    // "criteria": $('#criteria' + i).val(),
                };
                // arr[i]["conditionid"] = $('#condition_id'+i).val();
                // arr[i]["isdefault"] = 0;
                // if($("#customSwitch"+i).prop('checked')==true){
                //     arr[i]["isdefault"] = 0;
                // }
                // arr[i]["unit_constant"] = $('#unit_constant_list'+i).val();
            }
            if(arr.length>0)
            {
                var objectexp = {
                    "experiment_id": experiment_id,
                    "variation_id": variation_id,
                    "stream_id": stream_id,
                    "tab": "condition",
                    "template_id": template_id,
                    "stream_id": stream_id,
                    "type": type,
                    "arr": arr
                };
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ url("/experiment/experiment/sim_excel_config/exp_condition_config") }}',
                    data: JSON.stringify(objectexp),
                    arr: arr,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status === true) {
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
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Data is empty',
                })
            }  
        }
    }
</script>
