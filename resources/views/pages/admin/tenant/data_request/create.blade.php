@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item" ><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/'.$tenant_id.'/data_request')}}">Data Request</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Data Request</li>       
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/'.$tenant_id.'/data_request')}}" method="POST" role="tenant">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Data Request</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-6 col-lg-6">
                                            <label for="Name">Data Request Name
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Data Request Name"></i></span>
                                            </label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Data Request Name" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="source_file">Select .csv File<span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select .csv File"></i></span>
                                            </label>
                                            <input type="file" class="form-control-file" name="data_file" placeholder="Select .csv File">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description"> Description
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                                            </label>
                                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                        </div>

                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="tenant"]' class="btn btn-sm btn-secondary submit">Submit</button>
                                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            {{Config::get('constants.message.loader_button_msg')}}
                                        </button>
                                        <a href="{{url('/admin/tenant/'.$tenant_id.'/data_request')}}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        $(":input").inputmask();

        $("#select-all").click(function() {
            $('.checkSingle').not(this).prop('checked', this.checked);
        });

        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
        });
        $('input[type=checkbox]').click(function() {
            $(this).parent().find('li input[type=checkbox]').prop('checked', $(this).is(':checked'));
            var sibs = false;
            $(this).closest('ul').children('li').each(function() {
                if ($('input[type=checkbox]', this).is(':checked')) sibs = true;
            })
            $(this).parents('ul').prev().prop('checked', sibs);
        });
    });
</script>
@endpush
