@extends('layout.admin.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/manage/'.$tenant_id) }}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment') }}">Experiment Manage</a></li>
        <li class="breadcrumb-item"><a href="{{url('admin/tenant/'.$tenant_id.'/experiment/models')}}">Experiment Models</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Models</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form method="POST" action="{{url('admin/tenant/'.$tenant_id.'/experiment/models/'.___encrypt($models->id))}}" role="models">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create or Add Models</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Enter Name." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input value="{{$models->name}}" type="text" class="form-control" id="name" name="name" placeholder="Enter Name" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="version">Version
                                <i data-toggle="tooltip" title="Enter version." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" id="version" name="version" value="{{$models->version}}" placeholder="Enter Version" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="association">Association
                                <i data-toggle="tooltip" title="Enter Association." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" value="{{$models->association}}" class="form-control" id="association" name="association" disabled />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recommendations">Recommendations
                                <i data-toggle="tooltip" title="Enter Recommendations." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" value="{{$models->recommendations}}" class="form-control" id="recommendations" name="recommendations" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="list_of_models">List of Models
                                <i data-toggle="tooltip" title="Enter List of Models." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" value="{{$models->list_of_models}}" class="form-control" id="list_of_models" name="list_of_models" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="assumptions">Assumptions
                                <i data-toggle="tooltip" title="Enter Association." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" value="{{$models->assumptions}}" class="form-control" id="assumptions" name="assumptions" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <i data-toggle="tooltip" title="Add Description. You can enter maximum 1000 characters. " class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter Description" disabled>{{$models->description}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Update model code (<span id="file_name_view"></span>)
                                <i data-toggle="tooltip" title="Add Description. You can enter maximum 1000 characters. " class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <div id="ace_html">
                                <textarea id="ace_html" name="ace_html" rows="5" class="ace-editor w-100 ace_editor_val"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            @if(!empty($models->model_files))
                            @foreach($models->model_files as $file)
                            <ul>
                                <li>
                                    <a id="click_file" href="javascript:void(0)" data-request="ajax-get-file-content" data-url="{{url('models/get-file-content/'.___encrypt($file->id))}}" data-method="GET" data-target="#ace_html" class="click_file">{{$file->file_name}}
                                    </a>
                                </li>
                            </ul>
                            @endforeach
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label for="role_access_level">Save As New File?
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Save As New File"></i></span>
                            </label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" id="enable_new_file" class="form-check-input" name="new_file">
                                        Save
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6" style="display: none;" id="save_new_file_div">
                            <label for="name">Please Enter File Name
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Enter Name." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="file_name" name="file_name" placeholder="Enter File Name">
                        </div>
                    </div>
                    <input type="hidden" name="file_url" id="file_url">
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="models"]' class="btn btn-sm btn-secondary submit">
                            Submit
                        </button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('admin/tenant/'.$tenant_id.'/experiment/models')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/ace-builds/ace.js') }}"></script>
<script src="{{ asset('assets/plugins/ace-builds/theme-chaos.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#association').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Association',
            'placeholderColor': '#666666'
        });
        $('#assumptions').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Assumptions',
            'placeholderColor': '#666666'
        });
        $('#list_of_models').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add List Of Models',
            'placeholderColor': '#666666'
        });
        $('#recommendations').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Recommendations',
            'placeholderColor': '#666666'
        });
    });

    $('#enable_new_file').change(function() {
        if ($(this).is(':checked')) {
            $('#save_new_file_div').show();
        } else {
            $('#save_new_file_div').hide();
        }
    });

    if ($('#ace_html').length) {
        $(function() {
            var editor = ace.edit("ace_html");
            editor.setTheme("ace/theme/dracula");
            editor.getSession().setMode("ace/mode/html");
            editor.setOption("showPrintMargin", false)
        });
    }

    $("document").ready(function() {
        setTimeout(function() {
            $("#click_file").trigger('click');
        }, 10);
    });

    $(document).on('click', '[data-request="ajax-get-file-content"]', function() {
        $('#popup').show();
        $('.alert').remove();
        $(".has-error").removeClass('has-error');
        $('.error-message').remove();
        var $formData = new FormData();
        var $this = $(this);
        var $target = $this.data('target');
        var $url = $this.data('url');
        $.ajax({
            url: $url,
            type: 'GET',
            data: $formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function($response) {
                if ($response.status == true) {
                    $("#file_url").val($response.file_url);
                    $("#file_name_view").html($response.file_name);
                    var editor = ace.edit("ace_html");
                    editor.setValue($response.content);
                }
            }
        });
    });
</script>
@endpush