@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/graph-in')}}">Data Processing</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Data Processing</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form method="POST" action="{{url('/graph-in')}}" role="graph-in">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Generate Tolerance Graph</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tolerance_value">Tolerance Value
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Enter Tolerance Value." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="tolerance_value" name="tolerance_value" placeholder="Enter Tolerance Value Name">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" data-request="ajax-submit" data-target='[role="graph-in"]' class="btn btn-sm btn-secondary submit">
                            Submit
                        </button>
                        <a href="{{url('/graph-in')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>

</script>
@endpush