@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/reports/product_system_comparison')}}">Product System Comparison Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Product System Comparison Report</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/reports/product_system_comparison')}}" method="POST" role="report">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Product System Comparison Report</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="report_name">Report Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Specify a name for this report. The report will be saved in your database using this name for retrieval/modification in future."></i></span>
                            </label>
                            <input type="text" id="report_name" name="report_name" class="form-control" placeholder="Report Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="report_type">Select Report Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Report Type"></i></span>
                            </label>
                            <select name="report_type" id="report_type" class="form-control">
                                <option value="">Select Report Type</option>
                                <option value="standard">Standard</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_system">Select Product System
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product System"></i></span>
                            </label>
                            <select id="product_system" name="product_system" class="js-example-basic-single" required>
                                <option value="">Select Product System</option>
                                @if(!empty($product_systems))
                                @foreach($product_systems as $product_system)
                                <option value="{{___encrypt($product_system->id)}}">{{$product_system->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-sm-3 col-form-label" for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description"> Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">

                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="report"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="/reports/product_system_comparison" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush