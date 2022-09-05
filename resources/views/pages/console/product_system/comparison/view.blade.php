@extends('layout.console.master')
@push('plugin-styles')

<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/product_system/comparison')}}">Product System Comparison</a></li>
        <li class="breadcrumb-item active" aria-current="page">View <b>{{$data['edit']['comparison_name']}}</b> Product System Comparison
        </li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0"> Product System Comparison : {{$data['edit']['comparison_name']}}</h4>
            </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="comparison_name"> Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Product System Comparison Name"></i></span>
                            </label>
                            <input disabled value="{{$data['edit']['comparison_name']}}" type="text" class="form-control" name="comparison_name" placeholder="">
                        </div>
                        <?php
                        if (!empty($data['edit']['product_system'])) {
                            $arr = array_values($data['edit']['product_system']);
                        } else {
                            $arr = [];
                        }
                        ?>
                        <div class="form-group col-md-6">
                            <label for="product_system">Select Product System
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product System"></i></span>
                            </label>
                            <select disabled name="product_system[]" multiple="multiple" class="js-example-basic-multiple w-100">
                                <option value="">Select Product System</option>
                                @if(!empty($data['product_sys']))
                                @foreach($data['product_sys'] as $val)
                                @if (in_array($val['id'], $arr))
                                <option selected value="{{$val['id']}}">{{$val['name']}}</option>
                                @else
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            @if(count($data['product_sys']) === 0)
                            <label for="control-label">
                                <span class="text-danger">Please Add Product System </span>
                            </label>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description"> Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea disabled id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description">{{$data['edit']['description']}}</textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                            if (!empty($data['edit']['tags'])) {
                                $tag = implode($data['edit']['tags']);
                            } else {
                                $tag = "";
                            }
                            ?>
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags Names. You can enter maximum 16 values comma seperated"></i></span>
                            </label>
                            <input type="text" value="{{ $tag }}" name="tags[]" id="tags" disabled />
                        </div>
                    </div>
                    
                </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/js/tags-input.js') }}"></script>

<script>
    $('#tags').tagsInput({
        'interactive': true,
        'disabled': true,
        'defaultText': '',
        'removeWithBackspace': true,
        'width': '100%',
        'height': 'auto',
        'placeholderColor': '#666666'
    });
</script>
@endpush