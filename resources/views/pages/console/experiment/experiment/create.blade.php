@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush
<style>
    div.experiment_unit_section_scroll {
        /* height: 310px; */
        overflow-y: auto;
        min-height: 50px;
        max-height: 110px;
    }
</style>
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/experiment/experiment') }}">Experiment</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Experiment</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{ url('/experiment/experiment') }}" method="POST" role="process_exp">
                <div class="card-header">
                    <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Create Experiment</h5>
                </div>
                <div class="card-body">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="experiment_name">Experiment Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Name"></i></span>
                            </label>
                            <input type="text" class="form-control" data-request="isalphanumeric" id="experiment_name" name="experiment_name" required placeholder="Enter Experiment Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="data_source">Enter Data Source
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Data Source"></i></span>
                            </label>
                            <input type="text" class="form-control" name="data_source" data-request="isalphanumeric" required placeholder="Enter Data Source">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="project_id">Select Project
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Project"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-single" id="project_id" name="project">
                                <option value="">Select Project</option>
                                @if(!empty($projects))
                                @foreach($projects as $project)
                                <option value="{{___encrypt($project['id'])}}">{{$project['name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="classification_id">Select Classification
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Classification"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" id="classification_id" name="classification_id[]" multiple="multiple" required>
                                @if(!empty($experiment_classifications))
                                @foreach($experiment_classifications as $classification)
                                <option value="{{___encrypt($classification->id)}}">{{$classification->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category_id">Select Category
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Category"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-single" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @if(!empty($experiment_categories))
                                @foreach($experiment_categories as $category)
                                <option value="{{___encrypt($category->id)}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="product_form_group">
                            <label for="product">Select Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="product[]" id="product" multiple="multiple" required>
                                @foreach($chemicals as $chemical)
                                <option value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}</option>
                                @endforeach
                            </select>
                            <span id="product-error"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="main_product_input">Select Main Product Input <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Product Input"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="main_product_input[]" id="main_product_input" multiple="multiple" required>
                            </select>
                            <span id="main_product_input-error"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="main_product_output">Select Main Product Output <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Product Output"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="main_product_output[]" id="main_product_output" multiple="multiple" required>
                            </select>
                            <span id="main_product_output-error"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="energy">Select Energy Utility
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Energy Utility"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="energy[]" id="energy" multiple="multiple" required>
                                @foreach($energy as $enrgies)
                                <option value="{{___encrypt($enrgies->id)}}">{{$enrgies->energy_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="tags-style" class="form-control" data-request="isalphanumeric" name="tags" placeholder="Enter tags">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control" data-request="isalphanumeric"></textarea>
                        </div>
                        <div class="form-group col-md-6 experiment_unit_section_scroll">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Experiment Unit Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit Name"></i></span>
                                    </label>
                                    <input type="text" name="unit[0][unit]" class="form-control" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="experiment_unit">Select Experiment Unit
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                                    </label>
                                    <select data-width="100%" class="js-example-basic-single" name="unit[0][exp_unit]">
                                        <option value="">Select Experiment Unit</option>
                                        @if(!empty($experiment_units))
                                        @foreach($experiment_units as $experiment_unit)
                                        <option value="{{___encrypt($experiment_unit->id)}}">
                                            {{$experiment_unit->experiment_unit_name}}
                                        </option>
                                        @endforeach
                                        @else
                                        <option value="">Select Experiment Unit</option>
                                        @endif
                                    </select>
                                    <span id="unit0exp_unit-error"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label id="action_tour_id">&nbsp;
                                    </label><br>
                                    <button type="button" data-url="{{url('experiment/experiment/experiment_unit/add_more')}}" data-target="#test" data-request="add-another" data-count="0" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus text-secondary"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="test"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="process_exp"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/experiment/experiment') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
<script src="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{asset('assets/js/typeahead.js') }}"></script>
<script src="{{asset('assets/js/dropify.js') }}"></script>
<script>
    $('#tags').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });

    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }

    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }

    var obj = <?php echo json_encode($experiment_units) ?>;

    function remove_duplicate() {
        var code = {};
        $("select[name='main_product_input[]'] > option").each(function() {
            if (code[this.text]) {
                $(this).remove();
            } else {
                code[this.text] = this.value;
            }
        });
    }

    function remove_duplicate1() {
        var code = {};
        $("select[name='main_product_output[]'] > option").each(function() {
            if (code[this.text]) {
                $(this).remove();
            } else {
                code[this.text] = this.value;
            }
        });
    }

    $('#product').on('change', function() {
        $('#main_product_input').val('');
        $("#main_product_input").empty()
        //  $('#product option:selected').clone().appendTo('#main_product_input');
        $("#main_product_output").empty()
        //$('#product option:selected').clone().appendTo('#main_product_output');
        $.each($("#product option:selected"), function(i, item) {
            $('#main_product_input').append($('<option>', {
                value: item.value,
                text: item.text
            }));
            $('#main_product_output').append($('<option>', {
                value: item.value,
                text: item.text
            }));
        });
        remove_duplicate1();
        remove_duplicate();
    });
    // $(document).on("keypress", ".select2-input", function(event) {
    //     if (event.ctrlKey || event.metaKey) {
    //         var id = $(this).parents("div[class*='select2-container']").attr("id").replace("s2id_", "");
    //         var element = $("#" + id);
    //         if (event.which == 97) {
    //             var selected = [];
    //             $('.select2-drop-active').find("ul.select2-results li").each(function(i, e) {
    //                 selected.push($(e).data("select2-data"));
    //             });
    //             element.select2("data", selected);
    //         } else if (event.which == 100) {
    //             element.select2("data", []);
    //         }
    //     }
    // });
</script>
@endpush