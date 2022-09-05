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
        <li class="breadcrumb-item active" aria-current="page">Experiment Equipment</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/tenant/'.$tenant_id.'/experiment/equipment_unit/'.___encrypt($equipment_unit->id))}}" role="equipment" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Experiment Equipment Unit</h4>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="equipment_unit_name">Experiment Equipment Unit Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Equipment Unit Name"></i></span>
                            </label>
                            <input type="text" id="equipment_unit_name" class="form-control" name="equipment_unit_name" value="{{$equipment_unit->equipment_name}}" placeholder="Enter Experiment Equipment Unit Name">
                        </div>
                        <div class="form-group col-md-6"></div>
                        {{-- <div class="form-group col-md-6">
                            <label for="condition">Select Conditions
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i></span>
                            </label>
                            <select name="condition[]" class="js-example-basic-multiple multiple="multiple" >
                                @if(!empty($conditions))
                                <option value="" disabled>Select Conditions</option>

                                @foreach($conditions as $condition)
                                <option @if (in_array($condition->id, !empty($equipment_unit->condition)?$equipment_unit->condition:[])) selected @endif value="{{___encrypt($condition->id)}}">{{$condition->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div> --}}
                        <div class="form-group col-md-6">
                            <label for="condition">Select Conditions

                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i></span>
                            </label>
                            <select name="condition[]" class="js-example-basic-multiple" multiple="multiple" required>
                                <option value="" disabled>Select Conditions</option>
                                @if(!empty($conditions))
                                @foreach($conditions as $condition)
                                <option @if (in_array($condition->id, !empty($equipment_unit->condition)?$equipment_unit->condition:[])) selected @endif value="{{___encrypt($condition->id)}}">{{$condition->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="outcome">Select Outcomes

                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcomes"></i></span>
                            </label>
                            <select name="outcome[]" class="js-example-basic-multiple" multiple="multiple" data-live-search="true">
                                <option value="">Select Outcomes</option>
                                @if(!empty($outcomes))
                                @foreach($outcomes as $outcome)
                                <option @if (in_array($outcome->id, !empty($equipment_unit->outcome)?$equipment_unit->outcome:[])) selected @endif value="{{___encrypt($outcome->id)}}">{{$outcome->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @php
                        $stream_input_count=[];
                        $stream_output_count=[];
                        @endphp
                        @if(!empty($equipment_unit->stream_flow))
                        @foreach($equipment_unit->stream_flow as $count => $stream)
                        @if($stream['flow_type']=='input')
                        @php
                        $stream_input_count[]=$stream['id'];
                        @endphp
                        @endif
                        @if($stream['flow_type']=='output')
                        @php
                        $stream_output_count[]=$stream['id'];
                        @endphp
                        @endif
                        @endforeach
                        @endif
                        <div class="form-group col-md-6">
                            <label for="stream_name">Number Of Input Stream

                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number Of Input Stream"></i></span>
                            </label>
                            <input type="text" name="stream_flow_input" value="{{count($stream_input_count)}}" id="stream_flow_input" class="form-control" placeholder="Enter Number Of Input Stream">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stream_name">Number Of Output Stream

                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number Of Output Stream"></i></span>
                            </label>
                            <input type="text" name="stream_flow_output" value="{{count($stream_output_count)}}" id="stream_flow_output" class="form-control" placeholder="Enter Number Of Output Stream">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="unit_image">Select Experiment Unit Image
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit Image"></i></span>
                            </label>
                            <select name="unit_image" id="unit_image" class="js-example-basic-single">
                                <option value="">Select Experiment Unit Image</option>
                                @if(!empty($unit_images))
                                <option value="">Select Experiment Unit Image</option>
                                @foreach($unit_images as $unit_image)
                                <option data-img_src="{{url($unit_image->image)}}" @if(___encrypt($unit_image->id)==___encrypt($equipment_unit->unit_image)) selected @endif value="{{ ___encrypt($unit_image->id)}}">{{$unit_image->name}}</option>
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
                                <option @if($equipment_unit->model_id==$model_detail->id) selected @endif value="{{___encrypt($model_detail->id)}}">{{$model_detail->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{$equipment_unit->description}}</textarea>
                        </div>
                        @php
                        $tags = implode(",",!empty($equipment_unit->tags)?$equipment_unit->tags:[]);
                        @endphp
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <i data-toggle="tooltip" title="Enter Tags. You can enter maximum 16 values comma seperated" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" value="{{$tags}}" class="form-control" id="tags" name="tags" />
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="equipment"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/admin/tenant/'.$tenant_id.'/experiment/equipment_unit')}}" class="btn btn-sm btn-danger">Cancel</a>
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

    function custom_template(obj) {
        var data = $(obj.element).data();
        var text = $(obj.element).text();
        if (data && data['img_src']) {
            img_src = data['img_src'];
            template = $("<div class='media d-block d-sm-flex'><img class='align-self-center wd-50p mb-3 mb-sm-0 mr-3 wd-sm-50' src=\"" + img_src + "\" width='100px;' /><div class='media-body'><p class='mt-0'>" + text + "</p></div></div>");
            return template;
        }
    }

    $(function() {
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
            'placeholderColor': '#666666'
        });

        var options = {
            'templateResult': custom_template,
        }

        // Multi Select
        if ($(".js-basic-single").length) {
            $(".js-basic-single").select2();
        }

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2(options);
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

    });
</script>
@endpush
