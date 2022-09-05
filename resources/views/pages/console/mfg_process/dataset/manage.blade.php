@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
<link href="{{asset('assets/plugins/@mdi/css/materialdesignicons.min.css')}}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{url('/mfg_process/simulation')}}">Process Simulation</a></li>
                <li class="breadcrumb-item">
                    <a href="{{url('/mfg_process/simulation/'.___encrypt($process_dataset['process_id']).'/manage')}}"> Datasets</a>
                    - {{$process_dataset['dataset_name']}}
                </li>
                <li class="breadcrumb-item active">Manage</li>
            </ol>
        </nav>
    </div>
    <div class="mb-3 d-flex align-items-center flex-wrap text-nowrap mr-2">
        @php
            $simulationtype = get_simulation_stage($process_dataset['simulation_type']);
        @endphp
        <p class="mr-2 card-text text-muted">
        Simulation Type : <span class="badge badge-info ">{{$simulationtype['simulation_name']}}</span>
            <!-- <span class="font-weight-normal">Simulation Type :</span> {{$simulationtype['simulation_name']}}
            -->
        </p>
    </div>
</div>
<input type="hidden" id="txtid" value="{{___encrypt($process_dataset['process_id'])}}">
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <ul id="list-example" class="nav nav-tabs card-header-tabs">
                    @php
                        $simulation_type_details = get_simulation_stage($process_dataset['simulation_type']);
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link show active" id="mass_balance" onclick="tab_data('mass_balance')" data-toggle="tab" href="#mass_balance_tab" role="tab" aria-controls="mass_balance"  aria-selected="true">Mass Balance</a>
                    </li>
                    
                    @if(!empty($simulation_type_details['enery_utilities']))
                    <li class="nav-item">
                        <a class="nav-link"  id="energy_utilities" onclick="tab_data('energy_utilities')" data-toggle="tab" href="#mass_balance_tab" role="tab" aria-controls="energy_utilities" aria-selected="false">Energy Utilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  id="equipment_capital_cost" onclick="tab_data('equipment_capital_cost')" data-toggle="tab" href="#mass_balance_tab" role="tab" aria-controls="equipment_capital_cost" aria-selected="false">Equipment Capital Cost</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link"  id="key_process_info" onclick="tab_data('key_process_info')" data-toggle="tab" href="#mass_balance_tab" role="tab" aria-controls="key_process_info" aria-selected="false">Key Process Info</a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link"  id="qualitative_assesment" onclick="tab_data('qualitative_assesment')" data-toggle="tab" href="#mass_balance_tab" role="tab" aria-controls="qualitative_assesment" aria-selected="false">Qualitative Assesment</a>
                    </li>   
                </ul>
            </div>
            <div class="tab-content profile-tab" id="myTabContent">
            <div class="text-center">
                <div id="loading" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="tab-pane fade show active border" id="mass_balance_tab" role="tabpanel" aria-labelledby="mass_balance-tab">
                <div class="card ">
                    <div class="card-body">
                        <div class="mb-3 grid-margin" id="setData"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
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
    var viewflag = "{{$viewflag}}";
    var process_id = "{{___encrypt($process_dataset['process_id'])}}";
    var dataset_id = "{{___encrypt($process_dataset['id'])}}";
    function tab_data(tab) {
        //tab = $("#list-example .active").attr("id");
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('mfg_process/simulation/dataset/edit_config')}}",
            method: 'GET',
            data: {
                process_id: process_id,
                dataset_id: dataset_id,
                tab: tab,
                viewflag:viewflag
            },
            success: function(result) {
                $('#setData').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function set_default(id){
        if(document.getElementById('customSwitch'+id).checked){
            document.getElementById('unit_constant_list'+id).disabled=true
            document.getElementById('unit_constant_list'+id).value = document.getElementById('default'+id).value
        }else{
            document.getElementById('unit_constant_list'+id).disabled=false
        }
        
    }

    // function select_tab(){
    //     $('#list-example .nav-link').removeClass('active');
    //      $("#raw_material").addClass('active');
    //      select_default_tab()
    // }

    function Select_Tab(){
        setTimeout(function() {
            tab_data();
        });
    }

    function select_default_tab(){
        setTimeout(function() {
            $('#mass_balance').trigger('click');
        });
    }

    select_default_tab();
    
</script>
@endpush
