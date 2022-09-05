@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
<style>
    .add_more_button_align {
        margin-top: 30px;
    }
</style>
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{url('/dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{url('/experiment/experiment')}}">Experiments</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->experiment_id).'/manage')}}">
                Variations
            </a>
            - {{$variation->name}}
        </li>
        <li class="breadcrumb-item">
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->id).'/sim_excel_config')}}">
                Simulation Input Excel Template
            </a>
        </li>
        <li class="breadcrumb-item active">Manage</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    Template Name - <span> {{!empty($template->template_name)?$template->template_name:''}}</span>
                </div>
            </div>
            <div class="card-header">
                <ul id="type-list-example" class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link show active" id="forward" data-toggle="tab" onclick="select_tab()" role="tab" aria-controls="forward" aria-selected="true" >Forward</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="reverse" data-toggle="tab" onclick="select_tab()" role="tab" aria-controls="reverse" aria-selected="false">Reverse</a>
                    </li>
                </ul>
            </div>
            <div class="card-header">
                <ul id="list-example" class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link show active" id="raw_material" data-toggle="tab" href="#raw_material_tab" role="tab" aria-controls="raw_material" onclick="select_default_tab()" aria-selected="true">Raw Materials</a>
                    </li>
                    @if(!empty($variation['unit_specification']['master_units']) && $data['master_condition']>0)
                    <li class="nav-item">
                        <a class="nav-link"  id="master_condition" data-toggle="tab" href="#raw_material_tab" role="tab" aria-controls="master_condition" onclick="select_default_tab()" aria-selected="false">Master Conditions</a>
                    </li>
                    @endif
                    @if(!empty($variation['unit_specification']['experiment_units']) && $data['exp_condition']>0)
                    <li class="nav-item">
                        <a class="nav-link"  id="exp_condition" data-toggle="tab" href="#raw_material_tab" role="tab" aria-controls="exp_condition" onclick="select_default_tab()" aria-selected="false">Experiment Unit Conditions</a>
                    </li>
                    @endif
                    @if(!empty($variation['unit_specification']['master_units']) && $data['master_outcome']>0)
                    <li class="nav-item">
                        <a class="nav-link"  id="master_outcome" data-toggle="tab" href="#raw_material_tab" role="tab" aria-controls="master_outcome" onclick="select_default_tab()" aria-selected="false">Master Outcomes</a>
                    </li>
                    @endif
                    @if(!empty($variation['unit_specification']['experiment_units']) && $data['exp_outcome']>0)
                    <li class="nav-item">
                        <a class="nav-link"  id="exp_outcome" data-toggle="tab" href="#raw_material_tab" role="tab" aria-controls="exp_outcome" onclick="select_default_tab()" aria-selected="false">Experiment Unit Outcomes</a>
                    </li>
                    @endif
                </ul>
            </div>
            @include('pages.console.experiment.experiment.configuration.simulate_input_excel_template.manage_tabs')
        </div>
    </div>
</div> 
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
    var variation_id = "{{___encrypt($variation['id'])}}";
    var template_id = "{{___encrypt($template['id'])}}";
    var template_name = "{{$template['template_name']}}";
    var experiment_id = "{{___encrypt($process_experiment['id'])}}";
    function testing(stream_id, unit_tab) {
        type = $("#type-list-example .active").attr("id");
        tab = $("#list-example .active").attr("id");
        document.getElementById('setexpcon').value = 2;
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('experiment/experiment/sim_excel_config/'.___encrypt($template['id']).'/stream_data')}}",
            method: 'GET',
            data: {
                stream_id: stream_id,
                experiment_id: experiment_id,
                unit_tab_id: unit_tab,
                variation_id: variation_id,
                template_id:template_id,
                template_name:template_name,
                type:type,
                tab:tab
            },
            success: function(result) {
                $('#setData').html(result.html);
                if(tab!="raw_material"){
                    $("#data_div").removeClass("col-md-10");
                    $("#data_div").addClass("col-md-12");
                    $('#stream_list_div').hide();
                }else{
                    $("#data_div").removeClass("col-md-12");
                    $("#data_div").addClass("col-md-10");
                    $('#stream_list_div').show();
                }
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

    function select_tab(){
        $('#list-example .nav-link').removeClass('active');
         $("#raw_material").addClass('active');
         select_default_tab()
    }

    function select_default_tab(){
        setTimeout(function() {
            $("#v-tab a:first-child").trigger('click');
        });
    }

    select_default_tab();
</script>
@endpush