@extends('layout.console.master')

@push('plugin-styles')
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
<link href="{{asset('assets/plugins/@mdi/css/materialdesignicons.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/mfg_process/simulation') }}">Process Simulation</a></li>
        <li class="breadcrumb-item active" aria-current="page">Process Simulation Profile - <b>{{$data['edit']['process_name']}}</b></li>
    </ol>
</nav>
<div class="row">

    <div class="col-md-12 stretch-card">
        <div class="card shadow">


            <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0">Process Simulation :{{$data['edit']['process_name']}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if(!empty($data['edit']['tags']))
                    <h5 class="mr-2">Tags:
                        @foreach($data['edit']['tags'] as $tag)
                        <span class="badge badge-info">{{$tag}}</span>
                        @endforeach
                        @else
                    </h5>
                    @endif
                    <h5 class="mr-2">Status: <span class="badge badge-info">{{ucfirst($data['edit']['status'])}}</span></h5>
                    <a href="{{ url('/mfg_process/simulation/'.___encrypt($data['edit']['id']).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment">
                        <i class="fas fa-edit"></i>&nbsp;
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label class="control-label">Process Type: <span class="badge badge-info">{{$data['processtype']}}</span></label>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Process Category: <span class="badge badge-info">{{$data['processCategory']}}</span></label>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Main Feedstock: <span class="badge badge-info">{{$data['feed']}}</span></label>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Main Products: <span class="badge badge-info">{{$data['main_product']}}</span></label>
                    </div>


                    <div class="form-group col-md-6">
                        <label class="control-label">Selected Products:
                            @if(!empty($data['productName']))
                            @foreach($data['productName'] as $pn)
                            <span class="badge badge-info">{{$pn}}</span>
                            @endforeach
                            @endif
                        </label>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Selected Energy Utilities:
                            @if(!empty($data['utilityName']))
                            @foreach($data['utilityName'] as $un)
                            <span class="badge badge-info"> {{$un}} </span>
                            @endforeach
                            @endif
                        </label>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Process Status: <span class="badge badge-info">{{$data['processStatus']}}</span></label>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea disabled name="description" id="description" rows="5" class="form-control">{{$data['edit']['description']}}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div id="profileSpinner" class="spinner-border text-secondary" style="width: 3rem; height: 3rem;display: none;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
<script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/typeahead.js') }}"></script>
<script src="{{ asset('assets/js/dropify.js') }}"></script>
<script src="{{ asset('assets/js/test.js') }}"></script>
<script src="{{ asset('assets/js/tinymce.js') }}"></script>

<script type="text/javascript">
    $(function() {


        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

    });
</script>
@endpush