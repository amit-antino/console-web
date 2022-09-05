@extends('layout.console.master')

@push('plugin-styles')
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/@mdi/css/materialdesignicons.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/mfg_process/simulation')}}">Process Simulation</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Process Simulation</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/mfg_process/simulation')}}" method="POST" role="simulation">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Process Simulation</h4>
                </div>
                <div class="card-body">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="process_name">Process Simulation Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Process Simulation Name."></i></span>
                            </label>
                            <input type="text" class="form-control" name="process_name" data-request="isalphanumeric" placeholder="Enter Process Simulation Name" required>
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="process_type">Select Process Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Type"></i></span>
                            </label>
                            <select class="form-control" id="process_type" name="process_type">
                                <option disabled value="">Select Process Type</option>
                                @if(!empty($data['ProcessType']))
                                @foreach($data['ProcessType'] as $ptype)
                                <option value="{{___encrypt($ptype->id)}}">{{$ptype->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if (count($data['ProcessType']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Process Type </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="process_category">Select Process Category
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Category"></i></span>
                            </label>
                            <select class="form-control" name="process_category" id="process_category" required>
                                <option value="">Select Process Category </option>
                                @if(!empty($data['ProcessCategory']))
                                @foreach($data['ProcessCategory'] as $pcat)
                                <option value="{{___encrypt($pcat->id)}}">{{$pcat->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if (count($data['ProcessCategory']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Process Category </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-sm-6 ">
                            <label for="process_status">Select Process Status
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Status"></i></span>
                            </label>
                            <select class="form-control" name="process_status" id="process_status" required>
                                <option value="">Select Process status </option>
                                @if(!empty($data['ProcessStatus']))
                                @foreach($data['ProcessStatus'] as $pstatus)
                                <option value="{{___encrypt($pstatus->id)}}">{{$pstatus->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if (count($data['ProcessStatus']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add ProcessStatus </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="product">Select Products
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product(s)."></i></span>
                            </label>
                            <select class="js-example-basic-multiple" name="product[]" id="product" multiple="multiple" required>
                                <option value="0">Select Products</option>
                                @if(!empty($data['chemicals']))
                                @foreach($data['chemicals'] as $key => $value)
                                <option value="ch_{{___encrypt($value['id'])}}">{{$value['chemical_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if (count($data['chemicals']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Product</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="select_energy_utilities">Select Energy & Utility
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Energy Utility"></i></span>
                            </label>
                            <select class="js-example-basic-multiple" name="energy[]" id="select_energy_utilities" multiple="multiple">
                                <option value="0">Select Energy & Utility</option>
                                @foreach($data['EnergyUtility'] as $key => $value)
                                <option value="en_{{___encrypt($value['id'])}}">{{$value['energy_name']}}</option>
                                @endforeach
                            </select>
                            @if (count($data['EnergyUtility']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Energy Utility</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="main_feedstock">Select Main Feedstock
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Feedstock."></i></span>
                            </label>
                            <select class="js-example-basic-single" name="main_feedstock" id="main_feedstock" required>
                                <option value="">Select Main Feedstock</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="main_product">Select Main Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Product."></i></span>
                            </label>
                            <select class="js-example-basic-single" name="main_product" id="main_product" required>
                                <option value="">Select Main Product</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="tags-style" name="tags" placeholder="Enter tags">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Simulation Description"></i></span>
                            </label>
                            <textarea name="description" id="description" data-request="isalphanumeric" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="simulation"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{ url('/mfg_process/simulation') }}" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
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

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

        function remove_duplicate() {
            var code = {};
            $("select[name='main_product'] > option").each(function() {
                if (code[this.text]) {
                    $(this).remove();
                } else {
                    code[this.text] = this.value;
                }
            });
        }

        function remove_duplicate123() {
            var test = {};
            $("select[name='main_feedstock'] > option").each(function() {
                if (test[this.text]) {
                    $(this).remove();
                } else {
                    test[this.text] = this.value;
                }
            });
        }

        $('#product').on('change', function() {
            var main_product = $("#main_product").val();
            var main_feedstock = $("#main_feedstock").val();
             $("#main_product").empty()
             $("#main_feedstock").empty();
             $('#main_product').append($('<option>', {
                value: '',
                text: 'Select Main Product'
             }));
             $('#main_feedstock').append($('<option>', {
                value: '',
                text: 'Select Main Feedstock'
             }));
            $.each($("#product option:selected"), function(i, item) {
                $('#main_product').append($('<option>', {
                    value: item.value,
                    text: item.text
                }));
                $('#main_feedstock').append($('<option>', {
                    value: item.value,
                    text: item.text
                }));
            });

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

        // $('#select_energy_utilities').on('change', function() {
        //     $.each($("#select_energy_utilities option:selected"), function(i, item) {
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