@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('product_system/comparison')}}">Product System Comparisons</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Product System Comparison</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/product_system/comparison')}}" method="POST" role="product_cmp">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Product System Comparison</h4>
                </div>
                <div class="card-body">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="comparison_name">Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Product System Comparison Name"></i></span>
                            </label>
                            <input type="text" class="form-control" id="comparison_name" data-request="isalphanumeric" name="comparison_name" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_system">Select Product System
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product System"></i></span>
                            </label>
                            <select name="product_system[]" multiple="multiple" class="js-example-basic-multiple w-100">
                                <option value="">Select Product System</option>
                                @if(!empty($data['product_sys']))
                                @foreach($data['product_sys'] as $val)
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($data['product_sys']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Product System </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description"> Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" data-request="isalphanumeric" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags Names. You can enter maximum 16 values comma seperated"></i></span>
                            </label>
                            <input type="text" name="tags" id="tags" class="form-control" />
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="product_cmp"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/product_system/comparison/')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')

<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush
@push('custom-scripts')
<script src="{{asset('assets/js/select2.js')}}"></script>
<script src="{{ asset('assets/js/tags-input.js') }}"></script>
<script>
    $('#tags').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': 'auto',
        'placeholderColor': '#666666'
    });
</script>
@endpush