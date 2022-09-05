@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
<style type="text/css">
    .section_reaction {
        height: 150px;
        background-color: #8080802e;
    }

    .reac_Sep {
        font-size: 17px;
        font-weight: 500;
        margin-left: 1%;
        padding: 25px;
    }
</style>
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/other_inputs/reaction') }}">Reactions</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Reaction</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/other_inputs/reaction')}}" role="reaction" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Reaction</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="reaction_name">Enter Reaction Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Reaction Name"></i></span>
                            </label>
                            <input type="text" name="reaction_name" class="form-control" data-request="isalphanumeric" placeholder="Enter Reaction Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reaction_source">Enter Reaction Source
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Reaction Source"></i></span>
                            </label>
                            <input type="text" name="reaction_source" class="form-control" data-request="isalphanumeric" placeholder="Enter Reaction Source" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reaction_type">Select Reaction Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reaction Type"></i></span>
                            </label>
                            <select id="reaction_type" name="reaction_type" class="form-control">
                                <option value="">Reaction Type</option>
                                @if(!empty($reaction_type))
                                @foreach($reaction_type as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control" data-request="isalphanumeric"></textarea>
                        </div>
                        @include('pages.console.other_input.reaction.component')
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="reaction"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/other_inputs/reaction')}}" class="btn btn-sm btn-danger">Cancel</a>
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
<script src="{{ asset('assets/plugins/simplemde/simplemde.min.js') }}"></script>
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

        if ($("#tinymceExample").length) {
            tinymce.init({
                selector: "#tinymceExample",
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                },

                browser_spellcheck: true,
                height: 400,
                theme: "silver",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                ],
                image_advtab: true,
                templates: [{
                        title: "Test template 1",
                        content: "Test 1",
                    },
                    {
                        title: "Test template 2",
                        content: "Test 2",
                    },
                ],
                content_css: [],
            });
        }
    });


    $(document).ready(function() {
        $("#showhide").hide();
        $("#show_balance_details").click(function() {
            $("#showhide").toggle();
        });
        $('#show_balance_details').click(function() {
            $('.hidden-details').slideToggle("fast");
        });
    });

    function is_generic(obj, message) {
        var val = $(obj).val();
        if (val.indexOf("gp") != -1) {
            $(".gen_slc").show();
        }
        if (($(obj).closest('table').hasClass("table_reactants"))) {
            live_eq_r(obj);
        } else {
            live_eq_p(obj);
        }
    }

    function live_eq_r(obj) {
        left_eq_complete = "";
        right_eq_complete = "";
        var left_eq = "";
        var right_eq = "";
        var mol = "";
        var coef = "";
        $(".clone_con_r").find('tr').each(function(it, elt) {
            $(elt).find('td').each(function(i, el) {
                if ($(el).find(".dvalue").val() == undefined || $(el).find(".dvalue").val() == null) {
                    return true;
                }
                var dvalue = $(el).find(".dvalue").val();
                if (i < 2) {
                    if (i == 0) {
                        var molec_formula = $(el).find(".dvalue option:selected").text();
                        molec_formula = molec_formula.split('|');
                        if (molec_formula[1] == undefined || molec_formula[1].trim() == "") {
                            dvalue = "NAN";
                            $("#mfna").show();
                            setTimeout(function() {
                                //$("#mfna").hide(2000);
                            }, 1000);
                        } else {
                            dvalue = molec_formula[1];
                        }
                    }
                    left_eq += dvalue + "|";
                }
            });

            //interchange values here
            if (left_eq != "") {
                left_eq = left_eq.split('|');
                l_first = left_eq[0].replace(/(\d+)/g, '<sub>$1</sub>');
                l_second = left_eq[1];
                if (l_second == 1) {
                    coef = ""
                } else {
                    coef = l_second;
                }
                if ($.isNumeric(l_first)) {
                    left_eq_complete += l_first + coef + " + ";
                    mol += left_eq[0] + l_second + "+";
                    $("#l_equation").val(left_eq_complete);
                } else {
                    left_eq_complete += coef + l_first + " + ";
                    mol += l_second + left_eq[0] + "+";
                    $("#l_equation").val(left_eq_complete);
                }
            } //only if left_eq and right_eq has value
            left_eq = "";
        });
        $("#mole_left").val(mol.slice(0, -1));
        left_eq_complete = left_eq_complete.slice(0, -3);
        $(".l").html(left_eq_complete);
        $(".ir").html(left_eq_complete);
        $("#reaction_mole_left").val(left_eq_complete);
        document.getElementById("show_balance_details").click();
    }

    function live_eq_p(obj) {
        right_eq_complete = "";
        var right_eq = "";
        var mol = "";
        var coef = "";
        $(".clone_con_p").find('tr').each(function(it, elt) {
            $(elt).find('td').each(function(i, el) {
                if ($(el).find(".dvalue").val() == undefined || $(el).find(".dvalue").val() == null) {
                    return true;
                }
                var dvalue = $(el).find(".dvalue").val();
                if (i < 2) {
                    if (i == 0) {
                        var molec_formula = $(el).find(".dvalue option:selected").text();
                        molec_formula = molec_formula.split('|');
                        console.log(molec_formula);
                        if (molec_formula[1] == undefined || molec_formula[1].trim() == "") {
                            dvalue = "NAN";
                            $("#mfna").show();
                        } else {
                            dvalue = molec_formula[1];
                        }
                    }
                    right_eq += dvalue + "|";
                }
            });

            //interchange values here
            if (right_eq != "") {
                right_eq = right_eq.split('|');
                l_first = right_eq[0].replace(/(\d+)/g, '<sub>$1</sub>');
                l_second = right_eq[1];
                if (l_second == 1) {
                    coef = ""
                } else {
                    coef = l_second;
                }
                if ($.isNumeric(l_first)) {
                    right_eq_complete += l_first + coef + " + ";
                    mol += right_eq[0] + l_second + "+"
                    $("#r_equation").val(right_eq_complete);
                } else {
                    right_eq_complete += coef + l_first + " + ";
                    mol += l_second + right_eq[0] + "+";
                    $("#r_equation").val(right_eq_complete);
                }
            } //only if left_eq and right_eq has value
            right_eq = "";
        });
        // alert(mol);
        $("#mole_right").val(mol.slice(0, -1));
        right_eq_complete = right_eq_complete.slice(0, -3);
        $(".r").html(right_eq_complete);
        $(".il").html(right_eq_complete);
        $("#product_mole_left").val(right_eq_complete);
        document.getElementById("show_balance_details").click();
    }

    function forward_order(obj) {
        var value = "";
        var molec_formula = "";
        var fwd_order = "";
        var rate = [];
        var equation = "";
        $(".clone_con_r").find('tr').each(function(it, elt) {
            $(elt).find('td').each(function(i, el) {
                if ($(el).find(".dvalue").val() == undefined || $(el).find(".dvalue").val() == null) {
                    return true;
                }
                var fwd_in = $(el).find(".dvalue").val();
                if (i <= 2) {
                    if (i == 0) {
                        var molec_formula = $(el).find(".dvalue option:selected").text();
                        molec_formula = molec_formula.split('|');
                        fwd_in = molec_formula[1];
                    }
                    value += fwd_in + "|";
                }
            });
            //interchange values here
            if (value != "") {
                value = (value.slice(0, -1));
                rate.push(value);
            }
            value = "";
        });
        var elm = "";
        for (i = 0; i < rate.length; i++) {
            equation = rate[i].split("|");
            molec_formula = equation[0];
            fwd_order = equation[2];
            if (equation[2] == 1) {
                fwd_order = "";
                elm += "[" + molec_formula.replace(/(\d+)/g, '<sub>$1</sub>') + "]" + "<sup>" + fwd_order + "</sup>";
            }
            if (equation[2] > 1) {
                fwd_order = equation[2];
                elm += "[" + molec_formula.replace(/(\d+)/g, '<sub>$1</sub>') + "]" + "<sup>" + fwd_order + "</sup>";
            }
            if (equation[2] < 1) {
                elm += "";
            }
            $(".rate_eq").html("<label><b>Rate </b></label> = k" + elm);
        }
    }

    var sort_order = $(".clone_con_r").find(".sort_order_r").last().val();

    function clone_reac_r(obj) {
        sort_order = parseInt(sort_order) + 1;
        $(obj).closest('tr').find(".js-example-basic-single").select2("destroy");
        var cloned = $(obj).closest('tr').clone();
        cloned.find(".sort_order_r").val(sort_order);

        cloned.find("input[name='ra_count_r[]']").val("");
        cloned.find("input[name='fwr[]']").val("");
        cloned.find("input[name='reaction_phase[]']").val("");
        $(".clone_con_r").append(cloned);

        $.each($('.js-example-basic-single'), function(a) {
            $(this).removeAttr('data-select2-id').select2();
            $(".clone_con_r").find(".js-example-basic-single").select2();
        });
    }

    var sort_order_p = $(".clone_con_p").find(".sort_order_p").last().val();




    function clone_reac_p(obj) {

        sort_order_p = parseInt(sort_order_p) + 1;
        $(obj).closest('tr').find(".js-example-basic-single").select2("destroy");
        var cloned = $(obj).closest('tr').clone();
        cloned.find(".sort_order_p").val(sort_order_p);
        cloned.find("input[name='ra_count_p[]']").val("");
        cloned.find("input[name='bwr_p[]']").val("");
        cloned.find("input[name='product_reaction_phase[]']").val("");
        $(".clone_con_p").append(cloned);
        $.each($('.js-example-basic-single'), function(a) {
            $(this).removeAttr('data-select2-id').select2();
            $(".clone_con_p").find(".js-example-basic-single").select2();
        });
    }

    function remove_reac_r(obj) {
        var totalRowCount = $(".clone_con_r tr").length;
        var rowCount = $(".clone_con_r td").closest("tr").length;
        var message = "Total Row Count: " + totalRowCount;
        if (rowCount > 1) {
            $(obj).closest('tr').remove();
            live_eq_r();
            reactantsEqution();
        } else {
            //$(obj).closest('tr').style("background", "#000 !important")
        }
    }

    function remove_reac_p(obj) {
        var totalRowCount = $(".clone_con_p tr").length;
        var rowCount = $(".clone_con_p td").closest("tr").length;
        var message = "Total Row Count: " + totalRowCount;
        if (rowCount > 1) {
            $(obj).closest('tr').remove();
            live_eq_p();
            productEqution();
        } else {
            //$(obj).closest('tr').style("background", "#000 !important")
        }
    }

    function reactantsEqution() {
        var mole_val_left = $('#mole_left').val();
        var valueArray = $('.ra_count_r').map(function() {
            return this.value;
        }).get();
        var str = "";
        var reaction_phase = [];
        $('select[name="reaction_phase[]"] option:selected').each(function() {
            if ($(this).val() != 0)
                reaction_phase.push($(this).val());
        });
        var reactant_chm_r = [];
        $('select[name="reactant_chm_r[]"] option:selected').each(function() {
            reactant_chm_r.push($(this).text());
        });
        for (var i = 0; i < reactant_chm_r.length; i++) {
            molec_formula = reactant_chm_r[i].split('|');
            left_eq_complete = molec_formula[1].split(/(?<=^\S+)\s/);
            if (i > 0)
                str += "+"
            console.log(valueArray[i]);
            if (valueArray[i] != undefined || valueArray[i] !== null) {
                str += valueArray[i];
            }
            if (left_eq_complete[0] != undefined || left_eq_complete[0] !== null) {
                str += left_eq_complete[0];
            }
            console.log(reaction_phase[i]);
            if (reaction_phase[i] != undefined) {
                str += reaction_phase[i];
            }
        }
        $("#mole_left").val(mole_val_left);
        $(".l").html(str);
        $(".ir").html(str);
        $("#reaction_mole_left").val(str);
        document.getElementById("show_balance_details").click();
    }

    function productEqution() {
        var mole_val_right = $('#mole_right').val();
        var valueArray = $('.ra_count_p').map(function() {
            return this.value;
        }).get();
        var str = "";
        var product_reaction_phase = [];
        $('select[name="product_reaction_phase[]"] option:selected').each(function() {
            if ($(this).val() != 0)
                product_reaction_phase.push($(this).val());
        });
        var reactant_chm_p = [];
        $('select[name="reactant_chm_p[]"] option:selected').each(function() {
            reactant_chm_p.push($(this).text());
        });
        for (var i = 0; i < reactant_chm_p.length; i++) {
            molec_formula = reactant_chm_p[i].split('|');
            left_eq_complete = molec_formula[1].split(/(?<=^\S+)\s/);
            if (i > 0)
                str += "+"

            if (valueArray[i] != undefined || valueArray[i] !== null) {
                str += valueArray[i];
            }
            if (left_eq_complete[0] != undefined || left_eq_complete[0] !== null) {
                str += left_eq_complete[0];
            }
            if (product_reaction_phase[i] != undefined) {
                str += product_reaction_phase[i];
            }
        }
        $("#mole_right").val(mole_val_right);
        $(".r").html(str);
        $(".il").html(str);
        $("#product_mole_right").val(str);
        document.getElementById("show_balance_details").click();
    }
    // $(document).ready(function() {
    //     $('#show_balance_details').click(function() {
    //         // $('.hidden-details').slideToggle("fast");
    //         // Alternative animation for example
    //         // slideToggle("fast");
    //     });
    // });

    $(document).ready(function() {
        $("#show_balance_details").click(function() {
            $('.alert').remove();
            $(".has-error").removeClass('has-error');
            $('.help-block').remove();

            var reactent_molec_formula = $("#mole_left").val();
            var product_molec_formula = $("#mole_right").val();
            $.ajax({
                url: '{{url("/other_inputs/reaction/reaction_check_mole/")}}',
                type: 'POST',
                data: {
                    reactent_molec_formula: reactent_molec_formula,
                    product_molec_formula: product_molec_formula
                },
                success: function($response) {
                    if (Object.size($response.data) > 0) {
                        show_validation_error($response.data);
                    }
                    $("#broken_molecular_formula").html($response.html);
                }
            });
        });
    });
    $('#exchange_arrow').hide();
    $('#right_arrow').hide();
    $(document).ready(function() {
        $('#reaction_type').change(function() {
            var reaction_type = $('#reaction_type').val();
            if (reaction_type == 1) {
                $('#exchange_arrow').hide();
                $('#right_arrow').show();
            } else {
                $('#right_arrow').hide();
                $('#exchange_arrow').show();
            }
        });
    });
</script>
@endpush