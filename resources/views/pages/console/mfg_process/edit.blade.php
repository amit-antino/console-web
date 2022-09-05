@extends('layout.console.master')

@push('plugin-styles')
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/mfg_process/simulation')}}">Process Simulation</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Process Simulation - <b>{{$data['edit']['process_name']}}</b></li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form method="post" id="simedit" action="javascript:void(0)" enctype="multipart/form-data">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Process Simulation : {{$data['edit']['process_name']}}</h4>
                </div>
                <div class="card-body">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Process Simulation Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Process Simulation Name."></i></span>
                            </label>
                            <input type="text" class="form-control" name="process_name" id="process_name" data-request="isalphanumeric" value="{{$data['edit']['process_name']}}" required>
                            <span class="text-danger" id="err_process_name"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Select Process Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Type"></i></span>
                            </label>
                            <select class="form-control" name="process_type " id="process_type">
                                <option disabled value="">Select Process Type</option>
                                @if(!empty($data['ProcessType']))
                                @foreach($data['ProcessType'] as $ptype)
                                <option {{ (___encrypt($data["edit"]["process_type"]) == ___encrypt($ptype->id)) ? "selected" : "" }} value="{{___encrypt($ptype->id)}}">{{$ptype->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="err_process_type"></span>
                            @if(count($data['ProcessType']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Process Type </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="process_category">Select Process Category
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Category"></i></span>
                            </label>
                            <select class="form-control" name="process_category" id="process_category" required>
                                <option disabled value="">Select Process Category</option>
                                @if(!empty($data['ProcessCategory']))
                                @foreach($data['ProcessCategory'] as $pcat)
                                <option {{ (___encrypt($data["edit"]["process_category"]) == ___encrypt($pcat->id)) ? "selected" : "" }} value="{{___encrypt($pcat->id)}}">{{$pcat->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="err_process_category"></span>
                            @if(count($data['ProcessCategory']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Process Category</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="process_status">Select Process Status
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Status"></i></span>
                            </label>
                            <select class="form-control" name="process_status" id="process_status" required>
                                <option disabled value="">Select Process Status</option>
                                @if(!empty($data['ProcessStatus']))
                                @foreach($data['ProcessStatus'] as $pstatus)
                                <option {{ (___encrypt($data["edit"]["process_status"]) == ___encrypt($pstatus->id)) ? "selected" : "" }} value="{{___encrypt($pstatus->id)}}">{{$pstatus->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="err_process_status"></span>
                            @if(count($data['ProcessStatus']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Process Status </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Select Products
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product(s)."></i></span>
                            </label>
                            <?php
                            if (!empty($data['edit']['product'])) {
                                $chem = $data['edit']['product'];
                                $arr = array_column($chem, 'product');
                            } else {
                                $arr = [];
                            }
                            ?>
                            <select class="js-example-basic-multiple" name="product[]" id="product1" multiple="multiple" multiple-data-live-search="true" required>
                                @if(!empty($data['chemicals']))
                                @foreach($data['chemicals'] as $key => $value)
                                @if (in_array('ch_'.$value['id'], $arr))
                                <option selected value="ch_{{___encrypt($value['id'])}}">{{$value['chemical_name']}}</option>
                                @else
                                <option value="ch_{{___encrypt($value['id'])}}">{{$value['chemical_name']}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            <label> <span class="text-danger" id="err_product"></span></label>

                            @if(count($data['chemicals']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Product</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Select Energy & Utility
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Energy Utility"></i></span>
                            </label>
                            <?php
                            if (!empty($data['edit']['energy'])) {
                                $energyArr = $data['edit']['energy'];
                                $arr1 = array_column($energyArr, 'energy');
                            } else {
                                $arr1 = [];
                            }
                            ?>
                            <select class="js-example-basic-multiple" name="energy[]" id="energy1" multiple-data-live-search="true">
                                @if(!empty($data['EnergyUtility']))
                                @foreach($data['EnergyUtility'] as $key => $value)
                                @if (in_array('en_'.$value['id'], $arr1))
                                <option selected value="en_{{___encrypt($value['id'])}}">{{$value['energy_name']}}</option>
                                @else
                                <option value="en_{{___encrypt($value['id'])}}">{{$value['energy_name']}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            <label><span class="text-danger" id="err_energy"></span></label>
                            @if(count($data['EnergyUtility']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Energy Utilities</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                            $merge = array_merge($arr, $arr1);
                            ?>
                            <label for="main_feedstock">Select Main Feedstock
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Feedstock"></i></span>
                            </label>

                            <select class="js-example-basic-single" name="main_feedstock" id="main_feedstock" required>
                                <option value="0">Select Main Feedstock</option>

                                @if(!empty($data['ch_en']))
                                @foreach($data['ch_en'] as $m => $mval)
                                <option {{ (($data["edit"]["main_feedstock"]) == ($m)) ? "selected" : "" }} value="{{($m)}}">{{$mval}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="err_main_feedstock"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="main_product">Select Main Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Product"></i></span>
                            </label>
                            <select class="js-example-basic-single" name="main_product" id="main_product" required>
                                <option value="0">Select Main Product</option>
                                @if(!empty($data['ch_en']))
                                @foreach($data['ch_en'] as $m => $mval)
                                <option {{ (($data["edit"]["main_product"]) == ($m)) ? "selected" : "" }} value="{{($m)}}">{{$mval}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="err_main_product"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                            if (!empty($data['edit']['tags'])) {
                                $tag = implode($data['edit']['tags']);
                            } else {
                                $tag = "";
                            }
                            ?>
                            <label class="control-label">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags"></i></span>
                            </label>
                            <input type="text" value="{{ $tag }}" name="tags[]" id="tags" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Simulation Description"></i></span>
                            </label>
                            <textarea name="description" id="description" data-request="isalphanumeric" rows="2" class="form-control">{{$data['edit']['description']}}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submitEditprocess" class="btn btn-sm btn-secondary submit">Update</button>
                        <a href="{{url('/mfg_process/simulation')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/typeahead-js/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{asset('assets/js/typeahead.js')}}"></script>
<script src="{{asset('assets/js/dropify.js')}}"></script>
<script>
    $(function() {
        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

        $('#submitEditprocess').on('click', function(event) {
            var url = "{{URL('/mfg_process/simulation/'.___encrypt($data['edit']['id']))}}";
            var process_name = $("#process_name").val();
            var process_type = $("#process_type").val();
            var main_feedstock = $("#main_feedstock").val();
            var main_product = $("#main_product").val();
            var process_category = $("#process_category").val();
            var process_status = $("#process_status").val();
            var tags = $("#tags").val();
            var description = $("#description").val();
            //var sim_stage = $("#sim_stage").val();
            var product = [];
            $('select[name="product[]"] option:selected').each(function() {
                product.push($(this).val());
            });
            var energy = [];
            $('select[name="energy[]"] option:selected').each(function() {
                energy.push($(this).val());
            });
            var productlen = product.length;
            var dataExp = []
            for (var x = 0; x < productlen; x++) {
                var elementjson = {
                    "id": x,
                    "product": product[x]
                };
                dataExp.push(elementjson);
            }
            var energylen = energy.length;
            var dataenergy = []
            for (var x = 0; x < energylen; x++) {
                var elementjson = {
                    "id": x,
                    "energy": energy[x]
                };
                dataenergy.push(elementjson);
            }
            var objectexp = {
                "process_name": process_name,
                "process_type": process_type,
                "main_feedstock": main_feedstock,
                "main_product": main_product,
                "process_category": process_category,
                "process_status": process_status,
                "tags": tags,
                "description": description,
                //"sim_stage": sim_stage,
                "product": product,
                "energy": energy
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'PUT',
                url: url,
                data: JSON.stringify(objectexp),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data.errors);
                    if (data.success === true) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 30000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        })
                        window.location = "/mfg_process/simulation";
                    } else {
                        if (data.errors.length > 0) {
                            for (i in data.errors) {
                                // if (data.errors[i] == "sim_stage") {
                                //     document.getElementById('err_sim').innerHTML = "Please Select Simulation Type";
                                // } else
                                if (data.errors[i] == "process_name") {
                                    document.getElementById('err_process_name').innerHTML = "Please Enetr Process Name";
                                } else if (data.errors[i] == "product") {
                                    document.getElementById('err_product').innerHTML = "Please Select Products";
                                } else if (data.errors[i] == "energy") {
                                    document.getElementById('err_energy').innerHTML = "Please Select Energy";
                                } else if (data.errors[i] == "main_feedstock") {
                                    document.getElementById('err_main_feedstock').innerHTML = "Please Select Main feedstock";
                                } else if (data.errors[i] == "main_product") {
                                    document.getElementById('err_main_product').innerHTML = "Please Select Main product";
                                } else if (data.errors[i] == "process_category") {
                                    document.getElementById('err_process_category').innerHTML = "Please Select Process category";
                                } else if (data.errors[i] == "process_status") {
                                    document.getElementById('err_process_status').innerHTML = "Please Select Process Status";
                                }
                            }
                        }
                    }
                },
            });
        });

        function remove_duplicate() {
            var code = {};
            $("select[name='main_product'] > option").each(function() {
                if (code[this.value]) {
                    $(this).remove();
                } else {
                    code[this.value] = this.text;
                }
            });
        }

        function remove_duplicate123() {
            var test = {};
            $("select[name='main_feedstock'] > option").each(function() {
                if (test[this.value]) {
                    $(this).remove();
                } else {
                    test[this.value] = this.text;
                }
            });
        }

        $('#product1').on('change', function() {
            debugger;
            var main_product = $("#main_product").val();
            var main_feedstock = $("#main_feedstock").val();
            $("#main_product").empty()
            $("#main_feedstock").empty()
            $('#main_product').append($('<option>', {
                value: '',
                text: 'Select Main Product'
             }));
             $('#main_feedstock').append($('<option>', {
                value: '',
                text: 'Select Main Feedstock'
             }));
            $.each($("#product1 option:selected"), function(i, item) { //alert(item.value);
                $('#main_product').append($('<option>', {
                    value: item.value,
                    text: item.text
                }));
                $('#main_feedstock').append($('<option>', {
                    value: item.value,
                    text: item.text
                }));
            });
            console.log($('#main_feedstock'))
            var mainProductExists = ($("#main_product option[value='"+main_product+"']").length > 0);
            if(mainProductExists){
                $("#main_product").val(main_product);
            }
            var mainFeedStockExists = ($("#main_feedstock option[value='"+main_feedstock+"']").length > 0);
            if(mainFeedStockExists){
                $("#main_feedstock").val(main_feedstock);
            }
            remove_duplicate123();
            remove_duplicate();
        });

        // $('#energy1').on('change', function() {
        //     $.each($("#energy1 option:selected"), function(i, item) { //alert(item.value);
        //         $('#main_product').append($('<option>', {
        //             value: item.value,
        //             text: item.text
        //         }));
        //         $('#main_feedstock').append($('<option>', {
        //             value: item.value,
        //             text: item.text
        //         }));
        //     });
        //     remove_duplicate123();
        //     remove_duplicate();
        // });
    });
</script>
@endpush
