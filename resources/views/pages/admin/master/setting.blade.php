@extends('layout.admin.master')
@push('plugin-styles')
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update Settings</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/master/chemical/hazard/hazard/'.___encrypt($hazards->id))}}" role="hazard-edit" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Update Settings</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="hazard_class_id">Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Hazard Class"></i></span>
                            </label>

                            <input type="text" class="form-controle" name="name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_category_id">Logo
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Hazard Category"></i></span>
                            </label>
                            <input type="file" class="form-controle" name="name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hazard_pictogram_id">Cover Image
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Hazard Pictogram"></i></span>
                            </label>
                            <input type="file" class="form-controle" name="name">
                        </div>




                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="hazard-edit"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/admin/master/chemical/hazard/hazard') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
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
    });
</script>
@endpush