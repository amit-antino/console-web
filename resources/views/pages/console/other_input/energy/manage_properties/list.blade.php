@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@php 
$per = request()->get('sub_menu_permission');
$permission=!empty($per['profile']['method'])?$per['profile']['method']:[];
@endphp

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/other_inputs/energy') }}">Energy Utility</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Energy Properties - <b>{{ $product->chemical_name }}</b></li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-3 mb-md-0">Energy Properties : {{ $product->chemical_name }}</h4>
                    </div>
                    <a  class="btn btn-sm btn-secondary btn-icon-text" data-toggle="tooltip" data-placement="top" title="Edit Product"
                    @if(in_array('edit',$permission))
                        href="{{url('/other_inputs/energy/'.___encrypt($product->id).'/edit')}}"
                    @else
                        data-request="ajax-permission-denied"
                    @endif
                    >
                        <i class="btn-icon-prepend" data-feather="edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav nav-tabs nav-tabs-vertical " id="v-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($main_porperty as $key=>$property)
                            <a class="nav-link click-tab" id="v-{{$key}}-tab" data-toggle="pill" href="#v-{{$key}}" role="tab" aria-controls="v-{{$key}}" alt="{{$key}}" aria-selected="true">{{$property->property_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                            @if(!empty($properties))
                            @php 
                            $per = request()->get('sub_menu_permission');
                            $permission=!empty($per['properties']['method'])?$per['properties']['method']:[];
                            @endphp
                            @foreach ($properties as $key=>$property)

                            <div class="tab-pane" id="v-{{$key}}" role="tabpanel" aria-labelledby="v-{{$key}}-tab">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5>{{$property['property_name']}}</h5>
                                            </div>
                                            <a href="javascript:void(0);"  data-request="ajax-popup" data-target="#add-property" data-type="popup" data-tab="#modal-{{___encrypt($property['id'])}}" class="btn btn-sm btn-secondary btn-icon-text" id="fresh_up" alt="{{$key}}"
                                                @if(in_array('create',$permission))
                                                    data-url="{{ url('/other_inputs/energy/'.___encrypt($product->id).'/property/'.___encrypt($property['id']).'/popup') }}"
                                                @else
                                                    data-request="ajax-permission-denied"
                                                @endif
                                            >
                                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                                Add Property
                                            </a>
                                        </div>
                                    </div>
                                    <div id="view-catprops" class="card-body row">
                                        @if(!empty($property['sub_property']))
                                        @include('pages.console.other_input.energy.manage_properties.view')
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <!-- Starts View part Property Data -->
                            <div id="view-catprops"></div>
                            <!-- Ends View Products Property Data -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ~~~~~~~~~~~~~~~~~ All property View Section Closed ~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="add-property"></div>
<div id="edit-property"></div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        //Tags
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 20,
            'placeholderColor': '#666666'
        });
        //Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        $('a[href="#v-0"]').click();
        $('.click-tab').click(function() {
            var href = $(this).attr('href');
            window.location.hash = href;
            return;
        });

        $(function() {
            var val = location.hash + '-tab';
            $(val).trigger('click');
        });
        
    });
</script>
@endpush