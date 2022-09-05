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
                        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Stream -
                            {{$data['template_name']}}
                        </h5>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-12">
                        <label for="condition"><input type=checkbox id=checkall> Select Product List
                            <span>
                                <i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i>
                            </span>
                        </label>
                        <select class="js-example-basic-multiple" id="productid" name="productid[]" multiple="multiple">
                            @if(!empty($data['stream_data']->products) && $data['stream_data']->products!="[]")
                            @if(!empty($data['exp_product_list']))
                            @foreach($data['exp_product_list'] as $product)
                            @if(in_array(___encrypt($product['id']),$data['stream_data']->products))
                            <option selected value="{{___encrypt($product['id'])}}">{{$product['product_name']}}</option>
                            @else
                            <option value="{{___encrypt($product['id'])}}">{{$product['product_name']}}</option>
                            @endif
                            @endforeach
                            @endif
                            @else
                            @if(!empty($data['exp_product_list']))
                            @foreach($data['exp_product_list'] as $product)
                            <option value="{{___encrypt($product['id'])}}">{{$product['product_name']}}</option>
                            @endforeach
                            @endif
                            @endif
                        </select>
                    </div>


                    <input type="hidden" name="variation_id" id="variation_id" value="{{!empty($data['variation_id'])?$data['variation_id']:''}}">
                    <div class="form-group col-md-4">
                        <label for="process_experiment_name">Select Unit Type
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type"></i></span>
                        </label>
                        <select name="unit_id" id="unit_id" class="form-control" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/sim_excel_config/get_master_units')}}" data-method="POST" data-count="0" data-target="#unit_constant_list">
                            <option value="">Select Unit Type</option>
                            <option @if(!empty($data['stream_data']->unitid) && $data['stream_data']->unitid==10) selected @endif value="{{___encrypt(10)}}">Mass</option>
                            <option @if(!empty($data['stream_data']->unitid) && $data['stream_data']->unitid==4) selected @endif value="{{___encrypt(4)}}">Volume</option>
                            <option @if(!empty($data['stream_data']->unitid) && $data['stream_data']->unitid==3) selected @endif value="{{___encrypt(3)}}">Molar</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="process_experiment_name">Default Unit constant
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type"></i></span>
                        </label><br>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch" onclick="set_default_unit()" @if(!empty($variation_details['status']) && $variation_details['status']=='active' ) '' @else checked @endif>
                            <label class="custom-control-label" for="customSwitch"></label>
                        </div>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="unit_constant_id">Select Unit Constant
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type"></i></span>
                        </label>

                        <select name="unit_constant_id" id="unit_constant_list" class="form-control">
                            <option value="">Select Unit Constant</option>
                            @if(!empty($data['master_unit']))
                            @foreach($data['master_unit'] as $unit_type)
                            <option @if($data['stream_data']->unit_constant_id==$unit_type['id']) selected @endif value="{{___encrypt($unit_type['id'])}}" data-default_unit="{{!empty(getdefaultUnit($unit_type['id']))}}">{{$unit_type['unit_name']}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- <div class="card-footer text-right">
                    <button type="button" onclick="raw_material_config()" class="btn btn-sm btn-secondary submit">Submit</button>
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
        $('#productid').select2();

        $("#checkall").click(function(){
            if($("#checkall").is(':checked')){
                $("#productid > option").prop("selected", "selected");
                $("#productid").trigger("change");
            } else {
                $("#productid > option").prop("selected", false);
                $("#productid").trigger("change");
            }
        });
    });
    </script>
<script>
    set_default_unit();
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
            // if (type == 'reverse') {
            //     var productid = $("select[name='productid[]']")
            //         .map(function() {
            //             return $(this).val();
            //         }).get();
            //     var criteria = $("select[name='criteria[]']")
            //         .map(function() {
            //             return $(this).val();
            //         }).get();
            // } else {
                var productid = $('#productid').val();

            // }

            var unitid = $('#unit_id').val();
            var isdefault = 0;
            var unit_constant_id = $('#unit_constant_list').val();

            if ($("#customSwitch").prop('checked') == true) {
                var isdefault = 1;
            }
            if (productid.length == 0 || unitid == '' || unit_constant_id == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'please select product list,unit type and unit constant.',
                })
                return false;
            }
            var objectexp = {
                "experiment_id": experiment_id,
                // "criteria": criteria,
                "variation_id": variation_id,
                "stream_id": stream_id,
                "tab": "condition",
                "products": productid,
                "template_id": template_id,
                "stream_id": stream_id,
                "type": type,
                "unitid": unitid,
                "unit_constant_id": unit_constant_id,
                "isdefault": isdefault
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experiment/sim_excel_config/save_raw_material") }}',
                data: JSON.stringify(objectexp),
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
    }

    function set_default_unit() {
        if (document.getElementById('customSwitch').checked) {
            document.getElementById('unit_constant_list').disabled = true
        } else {
            document.getElementById('unit_constant_list').disabled = false
        }

    }
</script>
