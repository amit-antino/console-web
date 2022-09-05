@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<style type="text/css">
    .section_reaction {
        height: 150px;
        background-color: #8080802e;
    }
</style>
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/other_inputs/reaction')}}">Reactions</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit <b>{{$reaction_data->reaction_name}}</b> Reaction</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/other_inputs/reaction/'.___encrypt($reaction_data->id))}}" role="reaction" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Reaction : {{$reaction_data->reaction_name}}</h4>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="reaction_name">Enter Reaction Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Reaction Name"></i></span>
                            </label>
                            <input type="text" name="reaction_name" class="form-control" data-request="isalphanumeric" placeholder="Enter Reaction Name" value="{{$reaction_data->reaction_name}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reaction_source">Enter Reaction Source
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Reaction Source"></i></span>
                            </label>
                            <input type="text" name="reaction_source" class="form-control" data-request="isalphanumeric" placeholder="Enter Reaction Source" value="{{$reaction_data->reaction_source}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reaction_type">Select Reaction Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reaction Type"></i></span>
                            </label>
                            <select id="reaction_type" name="reaction_type" class="form-control">
                                <option value="">Reaction Type</option>
                                @if(!empty($reaction_type))
                                @foreach($reaction_type as $type)
                                <option @if($type->id==$reaction_data->reaction_type) selected @endif value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @php
                        $tags = implode(",",!empty($reaction_data->tags)?$reaction_data->tags:[]);
                        @endphp
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags" value="{{$tags}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control" data-request="isalphanumeric">{{$reaction_data->description}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Notes
                            </label>
                            <textarea class="form-control" name="tinymceExample" id="tinymceExample" data-request="isalphanumeric" rows="5">{{$reaction_data->notes}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="hidden" id="left_equation" name="left_equation" />
                            <input type="hidden" id="right_equation" name="right_equation" />
                            <input type="hidden" id="l_equation" name="l_equation" />
                            <input type="hidden" id="r_equation" name="r_equation" />
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4 class="mb-3 mb-md-0">Component</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                                            <div class="card shadow">
                                                <div class="card-header text-center">
                                                    <h5 class="mb-3 mb-md-0">Reactants</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table_reaction table_reactants" id="reactants_tour_id">
                                                            <thead>
                                                                <th>Select Chemical <span class="text-danger">*</span></th>
                                                                <th>Stoichiometric Coefficient <span class="text-danger">*</span></th>
                                                                <th>Forward Order </th>
                                                                <th>Reaction Phase </th>
                                                                <th>Base Component</th>
                                                                <th colspan="2">Action </th>
                                                            </thead>
                                                            <tbody class="clone_con_r">
                                                                @if(!empty($reactant_component_data))
                                                                @foreach($reactant_component_data as $reactant_data)
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="sort_order_r[]" value="1" class="sort_order_r" />
                                                                        <select id="mol_f" name="reactant_chm_r[]" onchange="reactantsEqution()" class="form-control _chm dvalue">
                                                                            @if(!empty($chemical))
                                                                            <option class="prd_rec" value="0" selected>Slecet Chemical</option>
                                                                            @foreach($chemical as $chem)

                                                                            <option @if($reactant_data['reactant_chemical']==$chem['molecular_formula']) selected @endif value="{{$chem['id']}}_{{$chem['molecular_formula']}}">
                                                                                {{$chem['chemical_name']}}|{{$chem['molecular_formula']}}
                                                                            </option>

                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td><input onkeyup="live_eq_r(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_r[]" class="form-control dvalue stoi_val validate_decimal ra_count_r" value="{{$reactant_data['stochiometric_coefficient']}}" /></td>
                                                                    <td><input type="text" min="1" max="99" onkeyup="forward_order(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="fwr[]" class="form-control dvalue fwd_in validate_decimal" value="{{$reactant_data['forward_order']}}" /></td>
                                                                    <td>
                                                                        <select name="reaction_phase[]" onchange="reactantsEqution()" class="form-control reaction_phase svalue " id="reaction_phase">
                                                                            <option value="0">Select Reaction Phase</option>
                                                                            @if(!empty($reaction_phase))
                                                                            @foreach($reaction_phase as $phase)
                                                                            @if($reactant_data['reaction_phase']==$phase['notation'])
                                                                            <option selected value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                                            @else
                                                                            <option value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                                            @endif
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="base_comp[]" class="form-control one_true_sel" id="change_val" data-request="alert-popup-reaction" data-target=".one_true_sel" data-ask_image="warning" data-ask="Only one component can be true for a given reaction. Are you sure, do you want to change the base component?">
                                                                            <option @if($reactant_data['base_component']=='true' ) selected @endif value="true">true </option>
                                                                            <option @if($reactant_data['base_component']=='false' ) selected @endif value="false">false</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="border-top:none"><i class="fas fa-plus text-secondary" onClick="clone_reac_r(this)" style="cursor:pointer"></i></td>
                                                                    <td style="border-top:none"><i class="fas fa-minus text-secondary" onClick="remove_reac_r(this)" style="cursor:pointer"></i></td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="sort_order_r[]" value="1" class="sort_order_r" />
                                                                        <select id="mol_f" name="reactant_chm_r[]" onchange="reactantsEqution()" class="js-example-basic-single _chm dvalue">
                                                                            @if(!empty($chemical))
                                                                            <option class="prd_rec" value="0" selected>Slecet Chemical</option>
                                                                            @foreach($chemical as $chem)
                                                                            <option value="{{$chem['id']}}_{{$chem['molecular_formula']}}">
                                                                                {{$chem['chemical_name']}}|{{$chem['molecular_formula']}}
                                                                            </option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td><input onkeyup="live_eq_r(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_r[]" class="form-control dvalue stoi_val validate_decimal ra_count_r" /></td>
                                                                    <td><input type="text" min="1" max="99" onkeyup="forward_order(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="fwr[]" class="form-control dvalue fwd_in validate_decimal" /></td>
                                                                    <td>
                                                                        <select name="reaction_phase[]" onchange="reactantsEqution()" class="form-control reaction_phase svalue " id="reaction_phase">
                                                                            <option value="0">Select Reaction Phase</option>
                                                                            @if(!empty($reaction_phase))
                                                                            @foreach($reaction_phase as $phase)
                                                                            <option value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="base_comp[]" class="js-example-basic-single one_true_sel" id="change_val" data-request="alert-popup-reaction" data-target=".one_true_sel" data-ask_image="warning" data-ask="Only one component can be true for a given reaction. Are you sure, do you want to change the base component?">
                                                                            <option value="true">true </option>
                                                                            <option selected value="false">false</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="border-top:none"><i class="fas fa-plus text-secondary" onClick="clone_reac_r(this)" style="cursor:pointer"></i></td>
                                                                    <td style="border-top:none"><i class="fas fa-minus text-secondary" onClick="remove_reac_r(this)" style="cursor:pointer"></i></td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h5 class="mb-3 mb-md-0">Products</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table table-responsive">
                                                        <table class="table table_reaction table_products" id="product_id">
                                                            <thead>
                                                                <th>Select Chemical <span class="text-danger">*</span></th>
                                                                <th>Stoichiometric Coefficient <span class="text-danger">*</span></th>
                                                                <th>Backward Order </th>
                                                                <th>Reaction Phase </th>
                                                                <th>Base Component</th>
                                                                <th colspan="2">Action </th>
                                                            </thead>
                                                            <tbody class="clone_con_p">
                                                                @if(!empty($product_component_data))
                                                                @foreach($product_component_data as $product_data)
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="sort_order_p[]" value="1" class="sort_order_p" />
                                                                        <select name="reactant_chm_p[]" onchange="productEqution()" class="js-example-basic-single _chm dvalue">
                                                                            @if(!empty($chemical))
                                                                            <option class="prd_sel" value="0" selected>Slecet Chemical</option>
                                                                            @foreach($chemical as $chem)
                                                                            <option @if($product_data['product_chemical']==$chem['molecular_formula']) selected @endif value="{{$chem['id']}}_{{$chem['molecular_formula']}}">
                                                                                {{$chem['chemical_name']}}|{{$chem['molecular_formula']}}
                                                                            </option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td><input onkeyup="live_eq_p(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_p[]" class="form-control dvalue validate_decimal ra_count_p" value="{{$product_data['stochiometric_coefficient']}}" /></td>
                                                                    <td><input type="text" min="1" max="99" onkeyup="if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="bwr_p[]" class="form-control dvalue validate_decimal" value="{{$product_data['backward_order']}}" /></td>
                                                                    <td>
                                                                        <select name="product_reaction_phase[]" onchange="productEqution()" class="form-control reaction_phase svalue " id="reaction_phase">
                                                                            <option value="0">Select Reaction Phase</option>
                                                                            @if(!empty($reaction_phase))
                                                                            @foreach($reaction_phase as $phase)
                                                                            @if($product_data['reaction_phase']==$phase['notation'])
                                                                            <option selected value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                                            @else
                                                                            <option value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                                            @endif
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="base_comp_p[]" class=" one_pro_true_sel" id="change_pro_val" data-request="alert-popup-reaction" data-target=".one_pro_true_sel" data-ask_image="warning" data-ask="Only one component can be true for a given reaction. Are you sure, do you want to change the base component?">
                                                                            <option @if($product_data['base_component']=='true' ) selected @endif value="true">true </option>
                                                                            <option @if($product_data['base_component']=='false' ) selected @endif value="false">false</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="border-top:none"><i class="fas fa-plus text-secondary" onClick="clone_reac_p(this)" style="cursor:pointer"></i></td>
                                                                    <td style="border-top:none"><i class="fas fa-minus text-secondary" onClick="remove_reac_p(this)" style="cursor:pointer"></i></td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="sort_order_p[]" value="1" class="sort_order_p" />
                                                                        <select name="reactant_chm_p[]" onchange="productEqution()" class="js-example-basic-single _chm dvalue">
                                                                            @if(!empty($chemical))
                                                                            <option class="prd_sel" value="0" selected>Slecet Chemical</option>
                                                                            @foreach($chemical as $chem)
                                                                            <option value="{{$chem['id']}}_{{$chem['molecular_formula']}}">
                                                                                {{$chem['chemical_name']}}|{{$chem['molecular_formula']}}
                                                                            </option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td><input onkeyup="live_eq_p(this);if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" type="text" min="1" max="99" name="ra_count_p[]" class="form-control dvalue validate_decimal ra_count_p" /></td>
                                                                    <td><input type="text" min="1" max="99" onkeyup="if(this.value>99){this.value='99';}else if(this.value<0){this.value='0';}" name="bwr_p[]" class="form-control dvalue validate_decimal" /></td>
                                                                    <td>
                                                                        <select name="product_reaction_phase[]" onchange="productEqution()" class="form-control reaction_phase svalue " id="reaction_phase">
                                                                            <option value="0">Select Reaction Phase</option>
                                                                            @if(!empty($reaction_phase))
                                                                            @foreach($reaction_phase as $phase)
                                                                            <option value="{{$phase->notation}}">{{$phase->notation}} {{$phase->name}}</option>
                                                                            @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="base_comp_p[]" class="one_pro_true_sel" id="change_pro_val" data-request="alert-popup-reaction" data-target=".one_pro_true_sel" data-ask_image="warning" data-ask="Only one component can be true for a given reaction. Are you sure, do you want to change the base component?">
                                                                            <option value="true">true </option>
                                                                            <option selected value="false">false</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="border-top:none"><i class="fas fa-plus text-secondary" onClick="clone_reac_p(this)" style="cursor:pointer"></i></td>
                                                                    <td style="border-top:none"><i class="fas fa-minus text-secondary" onClick="remove_reac_p(this)" style="cursor:pointer"></i></td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h5 class="mb-3 mb-md-0">Chemical Equation</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="live_eq_con row">
                                                        <div class="inner_seperator l col-md-5 bg-secondary text-white"></div>
                                                        <div class="col-md-2 text-center">
                                                            <span id="exchange_arrow"><i class="fas fa-exchange-alt"></i></span>
                                                            <span id="right_arrow"><i class="fas fa-arrow-right"></i></span>
                                                        </div>
                                                        <div class="inner_seperator r col-md-5 bg-secondary text-white"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-center">
                                                    <h5 class="mb-3 mb-md-0">Rate Equation</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="live_eq_con">
                                                        <div class="rate_eq"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="mole_left" name="reactan_mole" value="{{$reaction_data->reaction_reactant}}" />
                                    <input type="hidden" id="mole_right" name="product_mole" value="{{$reaction_data->reaction_product}}" />
                                    <input type="hidden" id="reaction_mole_left" name="reaction_mole_left" value="{{$reaction_data->chemical_reaction_left}}" />
                                    <input type="hidden" id="product_mole_right" name="product_mole_right" value="{{$reaction_data->chemical_reaction_right}}" />
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                                    <h5 class="mb-3 mb-md-0">Stoichiometric Balance</h5>
                                                    <button type="button" id="show_balance_details" class="btn btn-info btn-sm">Show details</button>
                                                </div>
                                                <div class="card-body" style="display:none;" id="showhide">
                                                    <input type="hidden" name="blnc" id="blnc" value="{{$reaction_data->balance}}">
                                                    <div id="stoichemi"></div>
                                                    <div class="row" id="broken_molecular_formula">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="reaction"]' class="btn btn-sm btn-secondary submit">Update</button>
                                <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    {{Config::get('constants.message.loader_button_msg')}}
                                </button>
                                <a href="{{url('/other_inputs/reaction')}}" class="btn btn-sm btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@php
$reaction_type = !empty($reaction_data->reaction_type)?$reaction_data->reaction_type:'';
@endphp
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        //Tags
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 20,
            'placeholderColor': '#666666'
        });
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
        if ($("#tinymceExample").length) {
            tinymce.init({
                selector: "#tinymceExample",
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                },
                browser_spellcheck: true,
                height: 400,
                theme: "silver",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                ],
                image_advtab: true,
                templates: [{
                        title: "Test template 1",
                        content: "Test 1",
                    },
                    {
                        title: "Test template 2",
                        content: "Test 2",
                    },
                ],
                content_css: [],
            });
        }
    });

    $(document).ready(function() {
        $("#showhide").hide();
        $("#show_balance_details").click(function() {
            $("#showhide").toggle();
        });
        $('#show_balance_details').click(function() {
            $('.hidden-details').slideToggle("fast");

        });
    });

    $(function() {
        reactantsEqution();
        productEqution();
    });

    function is_generic(obj, message) {
        var val = $(obj).val();
        if (val.indexOf("gp") != -1) {
            $(".gen_slc").show();
        }
        if (($(obj).closest('table').hasClass("table_reactants"))) {

            live_eq_r(obj);
        } else {
            live_eq_p(obj);
        }
    }

    function reactantsEqution() {
        var mole_val_left = $('#mole_left').val();
        var valueArray = $('.ra_count_r').map(function() {
            return this.value;
        }).get();

        var str = "";
        var reaction_phase = [];
        $('select[name="reaction_phase[]"] option:selected').each(function() {
            if ($(this).val() != 0)
                reaction_phase.push($(this).val());
        });

        var reactant_chm_r = [];
        $('select[name="reactant_chm_r[]"] option:selected').each(function() {

            reactant_chm_r.push($(this).text());
        });


        for (var i = 0; i < reactant_chm_r.length; i++) {
            molec_formula = reactant_chm_r[i].split('|');
            left_eq_complete = molec_formula[1].split(/(?<=^\S+)\s/);
            if (i > 0)
                str += "+"

            if (valueArray[i] != undefined || valueArray[i] !== null) {
                str += valueArray[i];
            }
            if (left_eq_complete[0] != undefined || left_eq_complete[0] !== null) {
                str += left_eq_complete[0];
            }
            if (reaction_phase[i] != undefined) {
                str += reaction_phase[i];
            }

        }
        $("#mole_left").val(mole_val_left);
        $(".l").html(str);
        $(".ir").html(str);
        $("#reaction_mole_left").val(str);
        document.getElementById("show_balance_details").click();

    }

    function productEqution() {
        var mole_val_right = $('#mole_right').val();
        var valueArray = $('.ra_count_p').map(function() {
            return this.value;
        }).get();

        var str = "";
        var product_reaction_phase = [];
        $('select[name="product_reaction_phase[]"] option:selected').each(function() {
            if ($(this).val() != 0)
                product_reaction_phase.push($(this).val());
        });

        var reactant_chm_p = [];
        $('select[name="reactant_chm_p[]"] option:selected').each(function() {
            reactant_chm_p.push($(this).text());
        });


        for (var i = 0; i < reactant_chm_p.length; i++) {
            molec_formula = reactant_chm_p[i].split('|');
            left_eq_complete = molec_formula[1].split(/(?<=^\S+)\s/);
            if (i > 0)
                str += "+"

            if (valueArray[i] != undefined || valueArray[i] !== null) {
                str += valueArray[i];
            }
            if (left_eq_complete[0] != undefined || left_eq_complete[0] !== null) {
                str += left_eq_complete[0];
            }
            if (product_reaction_phase[i] != undefined) {
                str += product_reaction_phase[i];
            }

        }

        $("#mole_right").val(mole_val_right);
        $(".r").html(str);
        $(".il").html(str);
        $("#product_mole_right").val(str);
        document.getElementById("show_balance_details").click();

    }

    function live_eq_r(obj) {
        left_eq_complete = "";
        right_eq_complete = "";
        var left_eq = "";
        var right_eq = "";
        var mol = "";
        var coef = "";
        $(".clone_con_r").find('tr').each(function(it, elt) {
            $(elt).find('td').each(function(i, el) {
                if ($(el).find(".dvalue").val() == undefined || $(el).find(".dvalue").val() == null) {
                    return true;
                }
                var dvalue = $(el).find(".dvalue").val();
                if (i < 2) {
                    if (i == 0) {
                        var molec_formula = $(el).find(".dvalue option:selected").text();
                        molec_formula = molec_formula.split('|');
                        if (molec_formula[1] == undefined || molec_formula[1].trim() == "") {
                            dvalue = "NAN";
                            $("#mfna").show();
                            setTimeout(function() {
                                //$("#mfna").hide(2000);
                            }, 1000);
                        } else {
                            dvalue = molec_formula[1];
                        }
                    }
                    left_eq += dvalue + "|";
                }
            });
            //interchange values here
            if (left_eq != "") {
                left_eq = left_eq.split('|');
                l_first = left_eq[0].replace(/(\d+)/g, '<sub>$1</sub>');
                l_second = left_eq[1];
                if (l_second == 1) {
                    coef = ""
                } else {
                    coef = l_second;
                }
                if ($.isNumeric(l_first)) {
                    left_eq_complete += l_first + coef + " + ";
                    mol += left_eq[0] + l_second + "+";
                    $("#l_equation").val(left_eq_complete);
                } else {
                    left_eq_complete += coef + l_first + " + ";
                    mol += l_second + left_eq[0] + "+";
                    $("#l_equation").val(left_eq_complete);
                }
            } //only if left_eq and right_eq has value
            left_eq = "";
        });
        $("#mole_left").val(mol.slice(0, -1));
        left_eq_complete = left_eq_complete.slice(0, -3);
        $(".l").html(left_eq_complete);
        $(".ir").html(left_eq_complete);
        $("#reaction_mole_left").val(left_eq_complete);
        document.getElementById("show_balance_details").click();
    }

    function live_eq_p(obj) {
        right_eq_complete = "";
        var right_eq = "";
        var mol = "";
        var coef = "";
        $(".clone_con_p").find('tr').each(function(it, elt) {
            $(elt).find('td').each(function(i, el) {
                if ($(el).find(".dvalue").val() == undefined || $(el).find(".dvalue").val() == null) {
                    return true;
                }
                var dvalue = $(el).find(".dvalue").val();
                if (i < 2) {
                    if (i == 0) {
                        var molec_formula = $(el).find(".dvalue option:selected").text();
                        molec_formula = molec_formula.split('|');
                        console.log(molec_formula);
                        if (molec_formula[1] == undefined || molec_formula[1].trim() == "") {
                            dvalue = "NAN";
                            $("#mfna").show();
                        } else {
                            dvalue = molec_formula[1];
                        }
                    }
                    right_eq += dvalue + "|";
                }
            });
            //interchange values here
            if (right_eq != "") {
                right_eq = right_eq.split('|');
                l_first = right_eq[0].replace(/(\d+)/g, '<sub>$1</sub>');
                l_second = right_eq[1];
                if (l_second == 1) {
                    coef = ""
                } else {
                    coef = l_second;
                }
                if ($.isNumeric(l_first)) {
                    right_eq_complete += l_first + coef + " + ";
                    mol += right_eq[0] + l_second + "+"
                    $("#r_equation").val(right_eq_complete);
                } else {
                    right_eq_complete += coef + l_first + " + ";
                    mol += l_second + right_eq[0] + "+";
                    $("#r_equation").val(right_eq_complete);
                }
            } //only if left_eq and right_eq has value
            right_eq = "";
        });
        $("#mole_right").val(mol.slice(0, -1));
        right_eq_complete = right_eq_complete.slice(0, -3);
        $(".r").html(right_eq_complete);
        $(".il").html(right_eq_complete);
        $("#product_mole_right").val(right_eq_complete);
        document.getElementById("show_balance_details").click();
    }

    function forward_order(obj) {
        var value = "";
        var molec_formula = "";
        var fwd_order = "";
        var rate = [];
        var equation = "";
        $(".clone_con_r").find('tr').each(function(it, elt) {
            $(elt).find('td').each(function(i, el) {
                if ($(el).find(".dvalue").val() == undefined || $(el).find(".dvalue").val() == null) {
                    return true;
                }
                var fwd_in = $(el).find(".dvalue").val();
                if (i <= 2) {
                    if (i == 0) {
                        var molec_formula = $(el).find(".dvalue option:selected").text();
                        molec_formula = molec_formula.split('|');
                        fwd_in = molec_formula[1];
                    }
                    value += fwd_in + "|";
                }
            });
            //interchange values here
            if (value != "") {
                value = (value.slice(0, -1));
                rate.push(value);
            }
            value = "";
        });
        var elm = "";
        for (i = 0; i < rate.length; i++) {
            equation = rate[i].split("|");
            molec_formula = equation[0];
            fwd_order = equation[2];
            if (equation[2] == 1) {
                fwd_order = "";
                elm += "[" + molec_formula.replace(/(\d+)/g, '<sub>$1</sub>') + "]" + "<sup>" + fwd_order + "</sup>";
            }
            if (equation[2] > 1) {
                fwd_order = equation[2];
                elm += "[" + molec_formula.replace(/(\d+)/g, '<sub>$1</sub>') + "]" + "<sup>" + fwd_order + "</sup>";
            }
            if (equation[2] < 1) {
                elm += "";
            }
            $(".rate_eq").html("<label><b>Rate </b></label> = k" + elm);
        }
    }
    forward_order();
    var sort_order = $(".clone_con_r").find(".sort_order_r").last().val();

    function clone_reac_r(obj) {
        sort_order = parseInt(sort_order) + 1;
        $(obj).closest('tr').find(".js-example-basic-single").select2("destroy");
        var cloned = $(obj).closest('tr').clone();
        cloned.find(".sort_order_r").val(sort_order);
        cloned.find("input[name='ra_count_r[]']").val("");
        cloned.find("input[name='fwr[]']").val("");
        cloned.find(".prd_rec").prop("selected", true);
        cloned.find("select[name='base_comp[]']").val('false');
        $(".clone_con_r").append(cloned);
        $.each($('.js-example-basic-single'), function(a) {
            $(this).removeAttr('data-select2-id').select2();
            $(".clone_con_r").find(".js-example-basic-single").select2();
        });

    }

    var sort_order_p = $(".clone_con_p").find(".sort_order_p").last().val();

    function clone_reac_p(obj) {
        sort_order_p = parseInt(sort_order_p) + 1;
        $(obj).closest('tr').find(".js-example-basic-single").select2("destroy");
        var cloned = $(obj).closest('tr').clone();
        cloned.find(".sort_order_p").val(sort_order_p);
        cloned.find("input[name='ra_count_p[]']").val("");
        cloned.find("input[name='bwr_p[]']").val("");
        cloned.find(".prd_sel").prop("selected", true);
        cloned.find("select[name='base_comp_p[]']").val('false');
        console.log('we');
        $(".clone_con_p").append(cloned);
        $.each($('.js-example-basic-single'), function(a) {
            $(this).removeAttr('data-select2-id').select2();
            $(".clone_con_p").find(".js-example-basic-single").select2();
        });
    }

    function remove_reac_r(obj) {
        var totalRowCount = $(".clone_con_r tr").length;
        var rowCount = $(".clone_con_r td").closest("tr").length;
        var message = "Total Row Count: " + totalRowCount;
        if (rowCount > 1) {
            $(obj).closest('tr').remove();
            live_eq_r();
            reactantsEqution();
        } else {
            //$(obj).closest('tr').style("background", "#000 !important")
        }
    }

    function remove_reac_p(obj) {
        var totalRowCount = $(".clone_con_p tr").length;
        var rowCount = $(".clone_con_p td").closest("tr").length;
        var message = "Total Row Count: " + totalRowCount;
        if (rowCount > 1) {
            $(obj).closest('tr').remove();
            live_eq_p();
            productEqution();
        } else {
            //$(obj).closest('tr').style("background", "#000 !important")
        }
    }

    $(document).ready(function() {
        $('#show_balance_details').click(function() {
            // $('.hidden-details').slideToggle("fast");
            // Alternative animation for example
            // slideToggle("fast");
        });
    });

    $(document).ready(function() {
        $("#show_balance_details").click(function() {
            var reactent_molec_formula = $("#mole_left").val();
            var product_molec_formula = $("#mole_right").val();
            $.ajax({
                url: '{{url("/other_inputs/reaction/reaction_check_mole/")}}',
                type: 'POST',
                data: {
                    reactent_molec_formula: reactent_molec_formula,
                    product_molec_formula: product_molec_formula
                },
                success: function($response) {
                    $("#broken_molecular_formula").html("");
                    console.log($response.html);
                    $("#broken_molecular_formula").html($response.html);
                }
            });
        });
    });
    @if($reaction_type == 1)
    $('#right_arrow').show();
    $('#exchange_arrow').hide();
    @else
    $('#exchange_arrow').show();
    $('#right_arrow').hide();
    @endif
    $(document).ready(function() {
        $('#reaction_type').change(function() {
            var reaction_type = $('#reaction_type').val();
            if (reaction_type == 1) {
                $('#exchange_arrow').hide();
                $('#right_arrow').show();
            } else {
                $('#right_arrow').hide();
                $('#exchange_arrow').show();
            }
        });
    });
</script>
@endpush