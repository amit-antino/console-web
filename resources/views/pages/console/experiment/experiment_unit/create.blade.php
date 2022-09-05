@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/experiment/experiment_units')}}">Experiment Units</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Experiment Unit</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/experiment/experiment_units')}}" method="POST" role="experiment_units">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Experiment Unit</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exp_unit_name">Enter Experiment Unit Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Unit Name"></i></span>
                            </label>
                            <input style="height:32px;" type="text" class="form-control" data-request="isalphanumeric" name="unit_name" placeholder="Enter Experiment Unit Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="equipment_unit">Select Experiment Equipment Unit
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Equipment Unit"></i></span>
                            </label>
                            <select style="height:32px;" name="equipment_unit" id="equipment_unit_id" class="js-example-basic-single">
                                <option data-img_src="{{ url('assets/images/20200707092023.png') }}" value="">Select Experiment Equipment Unit</option>
                                <!-- <option data-img_src="{{ url('assets/images/20200707092023.png') }}" value="new_equipment">Add New Equipment</option> -->
                                @if(!empty($equipment_units))
                                @foreach($equipment_units as $equipment_unit)
                                @if(!empty($equipment_unit->exp_unit_image->image))
                                <option data-img_src="{{url($equipment_unit->exp_unit_image->image)}}" value="{{___encrypt($equipment_unit->id)}}">{{$equipment_unit->equipment_name}}</option>
                                @else
                                <option data-img_src="{{url('assets/images/20200707092023.png')}}" value="{{___encrypt($equipment_unit->id)}}">{{$equipment_unit->equipment_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-row" id="condition_outcome"></div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                            </label>
                            <textarea id="description" name="description" data-request="isalphanumeric" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" data-request="isalphanumeric" placeholder="Enter Tags">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="experiment_units"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/experiment/experiment_units') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('pages.console.experiment.experiment_unit.add_equipment_unit_modal')
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

        $('#tags_equipment').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });

        function custom_template(obj) {
            var data = $(obj.element).data();
            var text = $(obj.element).text();
            if (data && data['img_src']) {
                img_src = data['img_src'];
                template = $("<div class='media d-block d-sm-flex'><img class='align-self-center wd-50p mb-3 mb-sm-0 mr-3 wd-sm-50' src=\"" + img_src + "\" width='100px;' /><div class='media-body'><p class='mt-0'>" + text + "</p></div></div>");
                return template;
            }
        }
        var options = {
            'templateResult': custom_template,
        }

        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2(options);
        }

        $('.js-example-basic-multiple').select2({
            dropdownParent: $('#equipmentModal')
        });

        $('#equipment_unit_id').on('change', function(e) {
            var val = $(this).val();
            if (val == 'new_equipment') {
                $('#equipmentModal').modal('show');
            } else {
                var $data = {
                    'id': val
                };
                var $method = 'GET';
                var $target = '#condition_outcome';
                $newurl = "{{url('experiment/experiment_units/equipment_condition_outcome?id=')}}" + val;
                $.ajax({
                    url: $newurl,
                    type: $method,
                    data: $data,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function($response) {
                        if ($response.status == true) {
                            $($target).html($response.html);
                        }
                    },
                });
            }
        });
    });
</script>
@endpush