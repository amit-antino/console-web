@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/organization/list')}}">Lists</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit List</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form method="POST" action="{{url('/organization/list/'.___encrypt($list->id))}}" role="listup">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Lists</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="list_name">Enter List Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter List Name" required></i></span>
                            </label>
                            <input type="text" class="form-control" data-request="isalphanumeric" name="list_name" value="{{$list->list_name}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="classification_id">Select Classification
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Classification"></i></span>
                            </label>
                            <select class="form-control" id="classification_id" name="classification_id" required data-validation-required-message="Classification is required">
                                <option value="">Select Classification</option>
                                @if(!empty($classification_list))
                                @foreach($classification_list as $classVal)
                                <option {{(___encrypt($list->classification_id) == ___encrypt($classVal->id) ) ? "selected" : "" }} value="{{___encrypt($classVal->id)}}">{{$classVal->classification_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($classification_list) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Classification</span></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="color_code">Select Color Code
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select color code"></i></span>
                            </label>
                            <select id="color_code" name="color_code" class="form-control" required>
                                <option value="">Select Color Code</option>
                                <option {{ ($list->color_code == "red" ) ? "selected" : "" }} value="red">Red</option>
                                <option {{ ($list->color_code == "orange" ) ? "selected" : "" }} value="orange">Orange</option>
                                <option {{ ($list->color_code == "yellow" ) ? "selected" : "" }} value="yellow">Yellow</option>
                                <option {{ ($list->color_code == "green" ) ? "selected" : "" }} value="green">Green</option>
                                <option {{ ($list->color_code == "none" ) ? "selected" : "" }} value="none">None</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_code">Display Hazard Code
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Display Hazard Code"></i></span>
                            </label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch">
                                <label class="custom-control-label" for="customSwitch"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="match_type">Select Match Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Match Type"></i></span>
                            </label>
                            <select name="match_type" id="match_type" class="form-control">
                                <option value="">Select Match Type</option>
                                <option {{ ($list->match_type == "col_based" ) ? "selected" : "" }} value="col_based">Column Based</option>
                                <option {{ ($list->match_type == "conditional" ) ? "selected" : "" }} value="conditional">Conditional</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category_id">Select List Category
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select List Category"></i></span>
                            </label>
                            <select id="category_id" name="category_id" class="form-control">
                                <option value="">Select List Category</option>
                                @if(!empty($category_list))
                                @foreach($category_list as $catVal)
                                <option {{(___encrypt($list->category_id) == ___encrypt($catVal->id) ) ? "selected" : "" }} value="{{___encrypt($catVal->id)}}">{{$catVal->category_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($category_list) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Category List</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="region">Select Region
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Region"></i></span>
                            </label>
                            <br>
                            <select name="region" id="region" class="form-control">
                                <option value="">Select Region</option>
                                <option {{ ($list->region == "all" ) ? "selected" : "" }} value="all">All</option>
                                <option {{ ($list->region == "spc" ) ? "selected" : "" }} value="spc">Specific Region</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_id">Select Country
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Country"></i></span>
                            </label>
                            <select id="country_id" name="country_id" data-url="{{url('state')}}" data-type="form" data-request="ajax-append-fields" data-target="#state_id" class="js-example-basic-single">
                                <option value="">Select Country</option>
                                @php
                                $country = \App\Models\Country::get();
                                @endphp
                                @if(!empty($country))
                                @foreach($country as $countries)
                                <option @if(___encrypt($countries->id)==___encrypt($list->country_id)) selected @endif value="{{___encrypt($countries->id)}}">{{$countries->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state_id">Select State / Province
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select State / Province"></i></span>
                            </label>
                            <select id="state_id" name="state_id" data-url="{{url('city')}}" data-type="form" data-request="ajax-append-fields" data-target="#city_id" class="js-example-basic-single">
                                <option value="">Select State / Province</option>
                                
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="compilation">Compiled by
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Compilation"></i></span>
                            </label>
                            <select id="compilation" name="compilation" class="form-control">
                                <option value="">Select Compiled by</option>
                                <option {{ ($list->compilation == "int" ) ? "selected" : "" }} value="int">Internal</option>
                                <option {{ ($list->compilation == "ext" ) ? "selected" : "" }} value="ext">External</option>
                            </select>
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="source_name">Enter Source Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Source Name"></i></span>
                               
                            </label>
                            <input type="text" class="form-control" data-request="isalphanumeric" name="source_name" value="{{$list->source_name}}">
                        </div> -->
                        <!-- 
                        <div class="form-group col-md-6">
                            <label for="no_of_list">Enter number of lists
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter number of lists"></i></span>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" name="no_of_list" value="{{$list->no_of_list}}">
                        </div>-->
                        <div class="form-group col-md-6">
                            <label for="source_file">Select Source File
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Source File"></i></span>
                            </label>
                            <input type="file" class="form-control-file" name="source_file" placeholder="Select Source File">
                        </div> 
                        <div class="form-group col-md-6">
                            <label for="source_url">Enter Source URL
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Source URL"></i></span>
                            </label>
                            <input type="text" class="form-control" name="source_url" value="{{$list->source_url}}">
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="converted_file">Select Converted File
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Converted File"></i></span>
                            </label>
                            <input type="file" class="form-control-file" name="	converted_file" placeholder="Select Converted File">
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="source_file">Select .csv File
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select .csv File"></i></span>
                                <a href="{{url('assets/sample/list-template.csv')}}" download=""> <span>Sample File Download <i class="icon-sm" data-feather="download" data-toggle="tooltip" data-placement="top" title="Sample File Download"></i></span></a>
                            </label>
                            <input type="file" class="form-control-file" name="csv_file" placeholder="Select .csv File">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hover_msg">Enter On Hover Message
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter On Hover Message"></i></span>
                            </label>
                            <input type="text" class="form-control" name="hover_msg" value="{{$list->hover_msg}}">
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                            if (!empty($list->tags)) {
                                $tags = implode(',', $list->tags);
                            } else {
                                $tags = "";
                            }
                            ?>
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="form-control" name="tags" value="{{$tags}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter description"></i></span>
                            </label>
                            <textarea type="text" id="description" rows="5" class="form-control" name="description" placeholder="Enter description">{{$list->description}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="field_of_display">Fields For Display
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Fields For Display"></i></span>
                            </label>
                            <table class="table">
                                <th colspan="6"><span> Select All &nbsp;&nbsp;<input type="checkbox" id="example-select-all"></span></th>
                                <tbody>
                                    <tr>
                                        <td style="display:none">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="chem_materialname" id="" @if(!empty($list->field_of_display) && in_array('chem_materialname',$list->field_of_display)) checked @endif class="checkSingle"> &nbsp; Chemical/Materialname
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="molecular_formula" @if(!empty($list->field_of_display) && in_array('molecular_formula',$list->field_of_display)) checked @endif id="" class="checkSingle"> &nbsp; Molecular Formula
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="cas_no"  @if(!empty($list->field_of_display) && in_array('cas_no',$list->field_of_display)) checked @endif id="" class="checkSingle"> &nbsp; CAS
                                                    No
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" @if(!empty($list->field_of_display) && in_array('inchi_key',$list->field_of_display)) checked @endif value="inchi_key" id="" class="checkSingle"> &nbsp; INCHI Key
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="ec_number" @if(!empty($list->field_of_display) && in_array('ec_number',$list->field_of_display)) checked @endif id="" class="checkSingle">&nbsp;EC
                                                    Number
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="listup' class="btn btn-sm btn-secondary submit">
                            Submit
                        </button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                        <a href="{{url('/organization/list')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        // Tags
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
    });

    $(function() {
        $("#example-select-all").click(function() {
            $('.checkSingle').not(this).prop('checked', this.checked);
        });
        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#example-select-all').prop('checked', true);
            } else {
                $('#example-select-all').prop('checked', false);
            }
        });
        $('.hs_country').hide();
        $('.hs_state').hide();
        $('#region_list').change(function() {
            console.log($(this).val());
            alert(2);
            if ($('#region_list').val() == 'spc') {
                $('.hs_country').show();
                $('.hs_state').show();
            } else {
                $('.hs_country').hide();
                $('.hs_state').hide();
            }
        });
    });
</script>
@endpush