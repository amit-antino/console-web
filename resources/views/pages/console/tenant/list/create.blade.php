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
        <li class="breadcrumb-item active" aria-current="page">Add Regulatory List</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/organization/list')}}" method="POST" role="list">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Lists</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="list_name">Enter List Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter List Name" required></i></span>
                            </label>
                            <input type="text" class="form-control" name="list_name" data-request="isalphanumeric" placeholder="Enter list Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="list_type">Select Classification
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Classification"></i></span>
                            </label>
                            <select class="form-control" name="classification_id">
                                <option value="">Select Classification</option>
                                @if(!empty($data['ClassificationList']))
                                @foreach($data['ClassificationList'] as $classVal)
                                <option value="{{___encrypt($classVal->id)}}">{{$classVal->classification_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($data['ClassificationList']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Classification</span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="color_code">Select Color Code
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select color code"></i></span>
                            </label>
                            <select id="color_code" name="color_code" class="form-control" required>
                                <option value="">Select Color Code</option>
                                <option value="red">Red</option>
                                <option value="orange">Orange</option>
                                <option value="yellow">Yellow</option>
                                <option value="green">Green</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_code">Display Hazard Code
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Display Hazard Code"></i></span>
                            </label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input form-control" id="display_hazard_code" name="display_hazard_code">
                                <label class="custom-control-label" for="display_hazard_code"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="match_type">Select Match Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Match Type"></i></span>
                            </label>
                            <select name="match_type" id="match_type" class="form-control">
                                <option value="">Select Match Type</option>
                                <option value="col_based">Column Based</option>
                                <option value="conditional">Conditional</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category_id">Select List Category
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select List Category"></i></span>
                            </label>
                            <select id="category_id" name="category_id" class="form-control">
                                <option value="">Select List Category</option>
                                @if(!empty($data['CategoryList']))
                                @foreach($data['CategoryList'] as $catVal)
                                <option value="{{___encrypt($catVal->id)}}">{{$catVal->category_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($data['CategoryList']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add CategoryList</span></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="region">Select Region
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Region"></i></span>
                            </label>
                            <select name="region" id="region" class="form-control">
                                <option value="">Select Region</option>
                                <option value="all">All</option>
                                <option value="spc">Specific Region</option>
                            </select>
                        </div>
                        <div id="country_hide" class="form-group col-md-6">
                            @include('pages.location.country')
                        </div>
                        <div id="state_hide" class="form-group col-md-6">
                            @include('pages.location.state')
                        </div>
                        <div class="form-group col-md-6">
                            <label for="compilation">Compiled By
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Compilation"></i></span>
                            </label>
                            <select id="compilation" name="compilation" class="js-example-basic-single">
                                <option value="" selected disabled>Select Compiled By</option>
                                <option value="int">Internal</option>
                                <option value="ext">External</option>
                            </select>
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="source_name">Enter Source Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Source Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="source_name" placeholder="Enter Source Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="source_url">Enter Source URL
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Source URL"></i></span>
                            </label>
                            <input type="text" class="form-control" name="source_url" placeholder="Enter Source URL">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_of_list">Enter number of lists
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter number of lists"></i></span>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" name="no_of_list" placeholder="Enter number of lists">
                        </div> -->
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
                            <input type="text" class="form-control" name="source_url" placeholder="Enter Source URL">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="source_file">Select .csv File
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select .csv File"></i></span>
                                <a href="{{url('assets/sample/list-template.csv')}}" download=""> <span>Sample File Download <i class="icon-sm" data-feather="download" data-toggle="tooltip" data-placement="top" title="Sample File Download"></i></span></a>
                            </label>
                            <input type="file" class="form-control-file" name="csv_file" placeholder="Select .csv File">
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="converted_file">Select Converted File
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Converted File"></i></span>
                            </label>
                            <input type="file" class="form-control-file" name="	converted_file" placeholder="Select Converted File">
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="hover_msg">Enter On Hover Message
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter On Hover Message"></i></span>
                            </label>
                            <input type="text" class="form-control" name="hover_msg" placeholder="Enter On Hover Message">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="form-control" name="tags" placeholder="Enter tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter description"></i></span>
                            </label>
                            <textarea type="text" id="description" class="form-control" data-request="isalphanumeric" rows="5" name="description" placeholder="Enter description"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="field_of_display">Fields For Display
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Fields For Display"></i></span>
                            </label>
                            <table class="table">
                                <th colspan="6"><span> Select All &nbsp;&nbsp;<input type="checkbox" id="example-select-all"></span></th>
                                <tbody>
                                    <tr>
                                        <!-- <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="chem_materialname" id="" class="checkSingle">&nbsp;Chemical/Materialname
                                                </label>
                                            </div>
                                        </td>
                                         -->
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="molecular_formula" id="" class="checkSingle">&nbsp;Molecular Formula
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="cas_no" id="" class="checkSingle">&nbsp;CAS
                                                    No
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="inchi_key" id="" class="checkSingle">&nbsp;INCHI Key
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="field_of_display[]" value="ec_number" id="" class="checkSingle">&nbsp;EC
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
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="list"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/organization/list')}}" class="btn btn-sm btn-danger">Cancel</a>
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
        $('#country_hide').hide();
        $('#state_hide').hide();
        $('#region').change(function() {
            if ($('#region').val() == 'spc') {
                $('#country_hide').show();
                $('#state_hide').show();
            } else {
                $('#country_hide').hide();
                $('#state_hide').hide();
            }
        });
    });
</script>
@endpush