@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/reports/product_system')}}">Product System Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Product System Report</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/reports/product_system')}}" method="POST" role="report">

                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Product System Report</h4>
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
                                <option value="0">Select Report Type</option>
                                <option value="standard">Standard</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_system">Select Product System
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product System"></i></span>
                            </label>
                            <select id="product_system" name="product_system" onchange="fetchProcessDetail(this.value)" class="js-example-basic-single" required>
                                <option value="">Select Product System</option>
                                @if(!empty($product_systems))
                                @foreach($product_systems as $product_system)
                                <option value="{{___encrypt($product_system->id)}}">{{$product_system->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_of_porcess">Number Of Processes
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Number Of Processes"></i></span>
                            </label>
                            <input type="text" id="pscount" name="pscount" readonly class="form-control bg-light">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="process_simulation">Process Simulation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Simulation"></i></span>
                            </label>
                            <select class="js-example-basic-multiple" name="process_simulation[]" id="process_simulation" multiple="multiple">
                                <option value="">Select Process</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description"> Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="report"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="/reports/product_system" class="btn btn-sm btn-danger">Cancel</a>
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
    function fetchProcessDetail(product_system_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/reports/product_system/productDetail') }}",
            method: 'GET',
            data: {
                id: product_system_id,
            },
            success: function(result) {
                var respObj = JSON.parse(result);

                var pscount = respObj['count'];

                document.getElementById('pscount').value = pscount;
                // obj = respObj['process'];
                // var html = "";
                // html += " <div class='table-responsive'>";
                // html += "<table class='table table-bordered overflow-auto'>";
                // for (i in obj) {
                //     html += "<tr>";
                //     html += "<td>";
                //     html += obj[i]['process_name'];
                //     html += "</td>";
                //     html += "</tr>";
                // }
                // html += "</table>";
                // html += "</div>";
                // console.log(html);
                // $('#sel_process').html(html);               
                $('#process_simulation').children('option:not(:first)').remove();
                $.each(respObj['process'], function(key, value) {
                    $('#process_simulation').append($('<option></option>').val(value['id']).html(value['process_name']))
                });
            }
        });
    }

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
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });
</script>
@endpush