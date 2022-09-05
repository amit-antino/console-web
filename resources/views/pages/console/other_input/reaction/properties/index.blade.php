@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/other_inputs/reaction')}}">Reactions</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{!empty($reaction_data->reaction_name)?$reaction_data->reaction_name:''}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-3 mb-md-0">{{!empty($reaction_data->reaction_name)?$reaction_data->reaction_name:''}} - Properties</h4>
                    </div>
                    <a href="{{url('/other_inputs/reaction/'.___encrypt($reaction_data['id']).'/edit')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Reaction">
                        <i class="btn-icon-prepend text-seconadary" data-feather="edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="control-label">Reaction Name</label>
                        <input type="text" disabled class="form-control" value="{{$reaction_data['reaction_name']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Reaction Source</label>
                        <input type="text" disabled class="form-control" value="{{$reaction_data['reaction_source']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Reaction</label>
                        <input type="text" disabled class="form-control" value="{{($reaction_data['chemical_reaction_left'])}}{{($reaction_data['chemical_reaction_right'])}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Inverse Reaction</label>
                        <input type="text" disabled class="form-control" value="{{($reaction_data['chemical_reaction_right'])}}{{($reaction_data['chemical_reaction_left'])}}">
                    </div>
                    @php
                    $tags = implode(",",!empty($reaction_data['tags'])?$reaction_data['tags']:[]);
                    @endphp
                    <div class="form-group col-md-4">
                        <label class="control-label">Tags</label>
                        <input type="text" disabled class="form-control" value="{{$tags}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Stoichiometric Status</label>
                        <input type="text" disabled class="form-control" value="{{$reaction_data['balance']}}">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-rate_parameter-tab" data-toggle="pill" href="#v-rate_parameter" alt="rate_parameter" role="tab" aria-controls="v-rate_parameter" aria-selected="true">Reaction Rate Parameters</a>
                            <a class="nav-link" id="v-equilibrium-tab" data-toggle="pill" href="#v-equilibrium" role="tab" alt="equilibrium" aria-controls="v-equilibrium" aria-selected="false">Equilibrium Constant</a>
                            <!-- <a class="nav-link" id="v-note-tab" data-toggle="pill" href="#v-note" role="tab" aria-controls="v-note" alt="note" aria-selected="false">Notes</a> -->
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                            @include('pages.console.other_input.reaction.properties.reaction_rate')
                            @include('pages.console.other_input.reaction.properties.equilibrium')
                            @include('pages.console.other_input.reaction.properties.note')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/simplemde/simplemde.min.js') }}"></script>
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
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
    /////////////////This is for Tabing make active//////////
    $('a[href="#v-rate_parameter"]').click();
    $('.click-tab').click(function() {
        var href = $(this).attr('href');
        window.location.hash = href;
        return;
    });

    $(function() {
        var val = location.hash + '-tab';
        $(val).trigger('click');
    });

    function select_type(obj) {
        var val = $(obj).closest("td").find(".sel_cat_exp").val();
        $(obj).closest("td").find(".cat_or_exp").val("");
        if (val == 'cat') {
            $(obj).closest("td").find(".cat_or_exp").get(0).type = 'number';
            $(obj).closest("td").find(".cat_or_exp").get(0).name = 'cat_or_exp_val[]';
            if ($(obj).next().data("cat_or_exp") == "cat") {
                $(obj).closest("td").find(".cat_or_exp").val($(obj).next().val());
            }
        }
        if (val == 'exp') {
            $(obj).closest("td").find(".cat_or_exp").get(0).type = 'text';
            $(obj).closest("td").find(".cat_or_exp").get(0).name = 'cat_or_exp_val[]';
            if ($(obj).next().data("cat_or_exp") == "exp") {
                $(obj).closest("td").find(".cat_or_exp").val($(obj).next().val());
            }
        }
        $(obj).closest("td").find(".cat_or_exp").show();
    }

    $('.rate-parameter-user').on('click', '.tr_clone', function() {
        var $tr = $(this).closest('.clone_tr');
        var $clone = $tr.clone();
        $clone.find(':text').val('');
        $tr.after($clone);
    });

    $('.rate-parameter-user').on('click', '.tr_clone_remove', function() {
        $(this).parents("tr").remove();
    });

    // calculation
    $('.rate-parameter-cal').on('click', '.tr_clone_cal', function() {
        var $tr = $(this).closest('.clone_row');
        var $clone = $tr.clone();
        $clone.find(':text').val('');
        $tr.after($clone);
    });

    $('.rate-parameter-cal').on('click', '.tr_clone_cal_remove', function() {
        $(this).parents("tr").remove();
    });

    // Equilibrium table row clone
    $('.equilibrium-user').on('click', '.equi_tr_clone', function() {
        var $tr = $(this).closest('.equi_clone_tr');
        var $clone = $tr.clone();
        $clone.find(':text').val('');
        $tr.after($clone);
    });

    $('.equilibrium-user').on('click', '.equi_tr_clone_remove', function() {
        $(this).parents("tr").remove();
    });

    // calculation
    $('.equilibrium-cal').on('click', '.equi_tr_clone_cal', function() {
        var $tr = $(this).closest('.equi_clone_row');
        var $clone = $tr.clone();
        $clone.find(':text').val('');
        $tr.after($clone);
    });

    $('.equilibrium-cal').on('click', '.equi_tr_clone_cal_remove', function() {
        $(this).parents("tr").remove();
    });

    function calculation_live_eq(obj) {
        var a = $('#a_cal').val();
        var e = $('#e_cal').val();
        var t = $('#temperature_k_cal').val();
        var dataString = {
            a: a,
            e: e,
            t: t
        };
        $.ajax({
            type: "POST",
            url: "calculate_reaction_rate",
            dataType: 'text',
            data: dataString,
            success: function(response) {
                var k = response;
                $('#rate_constant_cal').val(k);
            }
        });
        return false;
    }

    function calculation_live_eq_edit(obj) {
        var a = $('#a_cal_edit').val();
        var e = $('#e_cal_edit').val();
        var t = $('#temperature_k_cal_edit').val();
        var dataString = {
            a: a,
            e: e,
            t: t
        };
        $.ajax({
            type: "POST",
            url: "calculate_reaction_rate",
            dataType: 'text',
            data: dataString,
            success: function(response) {
                var k = response;
                $('#rate_constant_cal_edit').val(k);
            }
        });
        return false;
    }
</script>
@endpush