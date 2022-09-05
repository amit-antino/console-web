@extends('layout.console.master')

@push('plugin-styles')
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css')}}" rel="stylesheet" />
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
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/experiment/experiment')}}">Experiments</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Experiment - {{$process_experiment->process_experiment_name}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/experiment/experiment/'.___encrypt($process_experiment->id))}}" method="POST" role="process_exp">
                <input type="hidden" name="_method" value="PUT">
                <div class="card-header">
                    <h5 class="mb-3 mb-md-0 font-weight-normal">Edit Experiment : {{$process_experiment->process_experiment_name}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="process_experiment_names">Experiment Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Name"></i></span>
                            </label>
                            <input type="text" class="form-control" data-request="isalphanumeric" id="process_experiment_names" name="process_experiment_names" value="{{$process_experiment->process_experiment_name}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="data_source">Enter Data Source
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Data Source"></i></span>
                            </label>
                            <input type="text" class="form-control" data-request="isalphanumeric" id="data_source" name="data_source" value="{{$process_experiment->data_source}}" placeholder="Enter Data Source">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="project_id">Select Project
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Project"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-single" id="project_id" name="project_id">
                                <option value="">Select Project</option>
                                @if(!empty($projects))
                                @foreach($projects as $project)
                                <option @if($project['id'] == $process_experiment->project_id) selected @endif value="{{___encrypt($project['id'])}}">{{$project['name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="classification_id">Select Classification
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Classification"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" id="classification_id" name="classification_id[]" multiple="multiple" required>
                                @if(!empty($experiment_classifications))
                                @foreach($experiment_classifications as $ck => $classification)
                                @if(in_array($classification['id'],$process_experiment['classification_id']))
                                <option selected value="{{___encrypt($classification['id'])}}"> {{$classification['name']}}</option>
                                @else
                                @endif
                                <option value="{{___encrypt($classification['id'])}}"> {{$classification['name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="category_id">Select Category
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Category"></i></span>
                            </label>
                            <select ata-width="100%" class="js-example-basic-single" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @if(!empty($experiment_categories))
                                @foreach($experiment_categories as $category)
                                <option @if(___encrypt($category->id) == ___encrypt($process_experiment->category_id)) selected @endif value="{{___encrypt($category->id)}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-6" id="product_form_group">
                            <label for="product">Select Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="product[]" id="product" multiple="multiple">
                                @if(!empty($chemicals))
                                @foreach($chemicals as $chemical)
                                @if(in_array($chemical['id'],$process_experiment['chemical']))
                                <option selected value="{{ ___encrypt($chemical['id'])}}">{{$chemical['chemical_name']}}</option>
                                @else
                                <option value="{{ ___encrypt($chemical['id'])}}">{{$chemical['chemical_name']}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            <span id="product-error"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Select Main Product Input <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product Input"></i></span>
                                <span id="main_product_input123" class="text-danger"></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="main_product_input[]" id="main_product_input" multiple="multiple">
                                @if(!empty($product_input_lists))
                                @foreach($product_lists as $chemical_input)
                                @if(in_array($chemical_input->id,$process_experiment['main_product_input']))
                                <option selected value="{{ ___encrypt($chemical_input->id)}}">{{$chemical_input->chemical_name}}</option>
                                @else
                                <option value="{{ ___encrypt($chemical_input->id)}}">{{$chemical_input->chemical_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            <span id="main_product_input-error"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Select Main Product Output <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product Output"></i></span>
                                <span id="main_product_output123" class="text-danger"></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="main_product_output[]" id="main_product_output" multiple="multiple">
                                @if(!empty($product_output_lists))
                                @foreach($product_lists as $chemical_output)
                                @if(in_array($chemical_output->id,$process_experiment['main_product_output']))
                                <option selected value="{{ ___encrypt($chemical_output->id)}}">{{$chemical_output->chemical_name}}</option>
                                @else
                                <option value="{{ ___encrypt($chemical_output->id)}}">{{$chemical_output->chemical_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            <span id="main_product_output-error"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="energy">Select Energy Utility
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Energy Utility"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="energy[]" id="energy" multiple="multiple" required>
                                @if(!empty($energy))
                                @foreach($energy as $energies)
                                @if(!empty($process_experiment['energy_id']) && in_array($energies->id,$process_experiment['energy_id']))
                                <option selected value="{{ ___encrypt($energies->id)}}">{{$energies->energy_name}}</option>
                                @else
                                <option value="{{ ___encrypt($energies->id)}}">{{$energies->energy_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="form-control" name="tags" value="{{implode(',',$process_experiment->tags)}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{$process_experiment->description}}</textarea>
                        </div>
                        <div class="experiment_unit_section_scroll form-group col-md-6">
                            @php
                            $total_count = count($process_experiment->experiment_unit);
                            @endphp
                             <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Experiment Unit Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit Name"></i></span>
                                    </label>
                                    <input type="text" name="unit[{{$total_count+1}}][unit]" class="form-control" value="" placeholder="Experiment Unit Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="experiment_unit">Select Experiment Unit
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                                    </label>
                                    <select class="js-example-basic-single exp_unit" name="unit[{{$total_count+1}}][exp_unit]">
                                        <option value="">Select Experiment Unit</option>
                                        @if(!empty($experiment_units))
                                        @foreach($experiment_units as $experiment_unit)
                                        <option value="{{___encrypt($experiment_unit->id)}}">{{$experiment_unit->experiment_unit_name}}</option>
                                        @endforeach
                                        @else
                                        <option value="">Select Experiment Unit</option>
                                        @endif
                                    </select>
                                    <span class="unit[{{$total_count+1}}][exp_unit]" id="unit[{{$total_count+1}}][exp_unit]"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label id="action_tour_id">&nbsp;</label><br>
                                    <button type="button" data-url="{{url('experiment/experiment/experiment_unit/add_more')}}" data-target="#test" data-request="add-another" data-count="{{$total_count+1}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus text-secondary"></i>
                                    </button>
                                </div>
                            </div>
                            @if(!empty($process_experiment->experiment_unit))
                            @php
                            @$i=1;
                            @endphp
                            @foreach($process_experiment->experiment_unit as $count =>$exp_units)
                            <div class="form-row" id="remove-section-{{$count}}">
                                <div class="form-group col-md-6">
                                    <label for="">Experiment Unit Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit Name"></i></span>
                                    </label>
                                    <input type="text" value="{{!empty($exp_units['unit'])?$exp_units['unit']:''}}" name="unit[{{$count}}][unit]" class="form-control" value="" placeholder="Experiment Unit Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="experiment_unit">Select Experiment Unit
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                                    </label>
                                    <select class="js-example-basic-single exp_unit" name="unit[{{$count}}][exp_unit]">
                                        <option value="">Select Experiment Unit</option>
                                        @if(!empty($experiment_units))
                                        @foreach($experiment_units as $experiment_unit)
                                        <option @if(___encrypt($experiment_unit->id)==___encrypt($exp_units['exp_unit'])) selected="" @endif value="{{___encrypt($experiment_unit->id)}}">{{$experiment_unit->experiment_unit_name}}</option>
                                        @endforeach
                                        @else
                                        <option value="">Select Experiment Unit</option>
                                        @endif
                                    </select>
                                    <span class="unit[{{$count}}][exp_unit]" id="unit[{{$count}}][exp_unit]"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label id="action_tour_id">&nbsp;</label><br>

                                    <button type="button" class="btn btn-icon tr_clone_remove">
                                        <i class="fas fa-minus text-danger" data-target="#remove-section-{{$count}}" data-count="{{$count}}" data-request="remove"></i>
                                    </button>

                                </div>
                            </div>
                            @php $i++; @endphp
                            @endforeach
                            @else
                            @endphp
                            @php $total_count=0; @endphp
                            @endif

                            <div id="test"></div>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="process_exp"]' class="btn btn-sm btn-secondary submit">Update</button>
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
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
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

        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': '84px',
            'placeholderColor': '#666666'
        });

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
    });
</script>
@endpush
