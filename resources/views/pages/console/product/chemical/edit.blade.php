@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product/chemical') }}">Product</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit <b>{{$chemical->chemical_name}}</b> Product</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form method="POST" action="{{ url('/product/chemical/'.___encrypt($chemical->id)) }}" role="chemicals">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Product : {{$chemical->chemical_name}}</h4>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <div class="card-body">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="color_code">Selected Product Image
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Selected Product Image"></i></span>
                            </label>
                            @if(!empty($chemical->image))
                            <img src="{{url($chemical->image)}}" alt="" class="img-fluid" style="padding-bottom:15px;">
                            @else
                            <img src="" alt="" class="img-fluid" style="padding-bottom:15px;"><br>
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose File</label>
                            </div>
                        </div>
                        <div class="form-group col-md-9">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="chemical_name">Chemical Name
                                        <span class="text-danger">*</span>
                                        <i data-toggle="tooltip" title="Enter Chemical Name. Example: Butanol." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="form-control" data-request="isalphanumeric" id="chemical_name" name="chemical_name" value="{{$chemical->chemical_name}}" placeholder="Enter Chemical Name">
                                </div>

                                <input type="hidden" value="{{___encrypt('1')}}" name="product_type_id">
                                <div class="form-group col-md-6">
                                    <label for="category_id">Select Category
                                        <span class="text-danger">*</span>
                                        <i data-toggle="tooltip" title="Select Categoris." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <select class="form-control js-example-basic-single" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        @if(!empty($categories))
                                        @foreach($categories as $category)
                                        <option {{ (___encrypt($chemical->category_id) == ___encrypt($category->id)) ? "selected" : "" }} value="{{___encrypt($category->id)}}">{{$category->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="classification_id">Select Classification
                                        <span class="text-danger">*</span>
                                        <i data-toggle="tooltip" title="Select Classification" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <select class="form-control js-example-basic-single" id="classification_id" name="classification_id">
                                        @if(!empty($classifications))
                                        @foreach($classifications as $classification)
                                        <option {{ (___encrypt($chemical->classification_id) == ___encrypt($classification->id)) ? "selected" : "" }} value="{{___encrypt($classification->id)}}">{{$classification->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="product_brand_name">Product Brand Name
                                        <i data-toggle="tooltip" title="Enter Product Brand Name. Example: Omeprazole." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="form-control" data-request="isalphanumeric" id="product_brand_name" name="product_brand_name" value="{{$chemical->product_brand_name}}" placeholder="Enter Product Brand Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="iupac">International Union of Pure and Applied Chemistry - IUPAC
                                        <i data-toggle="tooltip" title="Enter International Union of Pure and Applied Chemistry. Example: butan-1-ol" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="form-control" id="iupac" name="iupac" value="{{$chemical->iupac}}" placeholder="Enter International Union of Pure and Applied Chemistry">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inchi">International Chemical Identifier - INCHI
                                        <i data-toggle="tooltip" title="Enter Pubchem CID. Example: InChI=1S/C4H10O/c1-2-3-4-5/h5H" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="form-control" id="inchi" name="inchi" value="{{$chemical->inchi}}" placeholder="Enter International Chemical Identifier">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inchi_key">International Chemical Identifier - INCHI Key
                                        <i data-toggle="tooltip" title="Enter INCHI Key. Example: LRHPLDYGYMQRHN-UHFFFAOYSA-N" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="form-control" id="inchi_key" name="inchi_key" value="{{$chemical->inchi_key}}" placeholder="Enter International Chemical Identifier Key">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ec_number">European Community - EC Number
                                        <i data-toggle="tooltip" title="Enter European Community. Multiple EC numbers allowed. Only special character allowed is '-' Example: 200-751-6, 238-128-6" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="form-control" id="ec_number" name="ec_number" value="{{$chemical->ec_number}}" placeholder="Enter European Community">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="molecular_formula">Molecular Formula
                                        <i data-toggle="tooltip" title="Enter Molecular Formula. Example: CH3CH2CH2CH2OH" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control molecular_formula_val" id="molecular_formula" name="molecular_formula" value="{{$chemical->molecular_formula}}" placeholder="Enter Molecular Formula">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-info" id="validate_molecular_formula" type="button">Validate</button>
                                        </div>
                                    </div>
                                    <span class="help-block text-danger" id="error_message_molecular_formula"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="own_product">Own Product</label>
                                    <select class="form-control js-example-basic-single" name="own_product" id="own_product">
                                        <option value="">Own Product</option>
                                        <option @if($chemical->own_product=='1') selected="" @endif value="1">Yes</option>
                                        <option @if($chemical->own_product=='2') selected="" @endif value="2">No</option>
                                    </select>
                                </div>
                                <!-- <div class="form-group col-md-6">
                                    <label for="vendor_list">Select Vendors
                                        <i data-toggle="tooltip" title="Select Suppliers and Vendors. You can select maximum 50 manufacturers from the dropdown." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <select class="js-example-basic-multiple" id="vendor_list" name="vendor_list[]" multiple="multiple" placeholder="Select Vendors">
                                        <option value="">Select Vendors</option>
                                        @if(!empty($vendors))
                                        @foreach($vendors as $vendor)
                                        <option value="{{___encrypt($vendor->id)}}">{{$vendor->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div> -->

                                <div class="form-group col-md-6">
                                    <label for="cas_number">Chemical Abstracts Service Number - CAS Number
                                        <i data-toggle="tooltip" title="Enter Chemical Abstracts Service Number. Example: 71-36-3" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    @php
                                    $cas_no = implode(",",!empty($chemical->cas_no)?$chemical->cas_no:[]);
                                    @endphp
                                    <input type="text" value="{{$cas_no}}" class="form-control" id="cas_number" name="cas_number" maxlength="10" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="other_name">Other Names
                                        <i data-toggle="tooltip" title="Enter Other Names." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    @php
                                    $other_name = implode(",",!empty($chemical->other_name)?$chemical->other_name:[]);
                                    @endphp
                                    <input type="text" value="{{$other_name}}" class="form-control" id="other_name" name="other_name" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tags">Tags
                                        <i data-toggle="tooltip" title="Enter tags." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    @php
                                    $tags = implode(",",!empty($chemical->tags)?$chemical->tags:[]);
                                    @endphp
                                    <input type="text" class="form-control" value="{{$tags}}" id="tags" name="tags" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>SMILES
                                        <i data-toggle="tooltip" title="Enter SMILES. Example: C=CC=O" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    @include('pages.console.product.chemical.edit-smiles')
                                    <div class="smiles" id="smiles">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="notes">Note
                                        <i data-toggle="tooltip" title="Add Notes." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <textarea class="form-control" data-request="isalphanumeric" rows="5" id="notes" name="notes" placeholder="Enter Note">{{$chemical->notes}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="chemicals"]' class="btn btn-sm btn-secondary submit">
                        Update
                    </button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{url('/product/chemical')}}" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

        $('#cas_number').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add CAS Number',
            'placeholderColor': '#666666',
            'maxChars': 10,
        });

        $('#other_name').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add Other Names',
            'placeholderColor': '#666666'
        });

        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
            'placeholderColor': '#666666'
        });
    });
    $(document).ready(function() {
        $('#molecular_formula').on('keyup', function() {
            var molecular_formula = $('#molecular_formula').val().replace(/[^A-Za-z0-9--.]/g, "");
            $('.molecular_formula_val').val(molecular_formula);
        });
    });
    $(document).ready(function() {
        $("#validate_molecular_formula").click(function() {
            var molec_formula = $("#molecular_formula").val();
            dataString = 'molecular_formula=' + molec_formula;

            $.ajax({
                type: "POST",
                url: "{{url('product/chemical/check_molecular_formula')}}",
                data: dataString,
                success: function(response) {
                    console.log(response.message);
                    if (response.status == false) {
                        $("#error_message_molecular_formula").html(response.message); //Display message! ;)
                    } else {
                        $("#error_message_molecular_formula").html(response.html); //Display message! ;)
                        //$("#broken_molecular_formula").show();
                    }

                }
            });
            return false;
        });
    });
</script>
@endpush