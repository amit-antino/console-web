@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/manage/'.$tenant_id) }}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment') }}">Experiment Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Experiment Equipment Unit</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/tenant/'.$tenant_id.'/experiment/equipment_unit')}}" role="equipment" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Experiment Equipment Unit</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="equipment_unit_name">Experiment Equipment Unit Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Equipment Unit Name"></i></span>
                            </label>
                            <input type="text" class="form-control" id="equipment_unit_name" name="equipment_unit_name" placeholder="Enter Experiment Equipment Unit Name">
                        </div>
                        <div class="form-group col-md-6"></div>
                        <div class="form-group col-md-6">
                            <label for="condition">Select Conditions
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i></span>
                            </label>
                            <select name="condition[]" class="js-example-basic-multiple" multiple="multiple" required>
                                <option value="" disabled>Select Conditions</option>
                                @if(!empty($conditions))
                                @foreach($conditions as $condition)
                                <option value="{{___encrypt($condition->id)}}">{{$condition->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="outcome">Select Outcomes

                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcomes"></i></span>
                            </label>
                            <select name="outcome[]" class="js-example-basic-multiple" multiple="multiple" required>
                                <option value="" disabled>Select Outcomes</option>
                                @if(!empty($outcomes))
                                @foreach($outcomes as $outcome)
                                <option value="{{___encrypt($outcome->id)}}">{{$outcome->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stream_name">Number Of Input Streams

                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number Of Input Streams"></i></span>
                            </label>
                            <input type="text" name="stream_flow_input" id="stream_flow_input" class="form-control" placeholder="Enter Number Of Input Streams" onkeypress="return isNumber(event)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stream_name">Number Of Output Streams
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number Of Output Streams"></i></span>
                            </label>
                            <input type="text" name="stream_flow_output" id="stream_flow_output" class="form-control" placeholder="Enter Number Of Output Stream" onkeypress="return isNumber(event)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="unit_image">Select Experiment Unit Image
                                <span><i class="icon-xs" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit Image"></i></span>
                            </label>
                            <select name="unit_image" id="unit_image" class="js-example-basic-single form-control">
                            <option data-img_src="" value="">select</option>
                            <option value="">Select Unit Image</option>
                                @if(!empty($unit_images))
                                @foreach($unit_images as $unit_image)
                                <option data-img_src="{{url($unit_image->image)}}" value="{{___encrypt($unit_image->id)}}">{{$unit_image->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="models">Select Models
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Models"></i></span>
                            </label>
                            <select name="models" id="models">
                                <option value="" selected disabled>Select Models</option>
                                @if(!empty($models))
                                @foreach($models as $model_detail)
                                <option value="{{___encrypt($model_detail->id)}}">{{$model_detail->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Enter Tags">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="equipment"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('admin/tenant/'.$tenant_id.'/experiment/equipment_unit')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
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
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
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
            'templateSelection': custom_template,
            'templateResult': custom_template,
        }

        // Multi Select
        $(".js-basic-single").select2();

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2(options);
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });
</script>
@endpush
