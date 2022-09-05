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
        <li class="breadcrumb-item active" aria-current="page">Edit Product System Report</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/reports/product_system')}}" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Product System Report</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
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
                                <option value="">Select Report Type</option>
                                <option value="standard">Standard</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
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
                        <div class="form-group col-md-4">
                            <label for="no_of_porcess">Number Of Processes
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Number Of Processes"></i></span>
                            </label>
                            <input type="text" id="pscount" disabled class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Product System Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Product System Name"></i></span>
                            </label>
                            <input type="text" id="psname" disabled class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="processes">Processes
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Processes"></i></span>
                            </label>
                            <div id="sel_process"></div>
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
                    <button type="submit" class="btn btn-sm btn-secondary submit">Submit</button>
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
                var psname = respObj['name'];
                var pscount = respObj['count'];
                document.getElementById('psname').value = psname;
                document.getElementById('pscount').value = pscount;
                obj = respObj['process'];
                var html = "";
                html += " <div class='table-responsive'>";
                html += "<table class='table table-bordered overflow-auto'>";
                for (i in obj) {
                    html += "<tr>";
                    html += "<td>";
                    html += obj[i]['process_name'];
                    html += "</td>";
                    html += "</tr>";
                }
                html += "</table>";
                html += "</div>";
                console.log(html);
                $('#sel_process').html(html);
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
    });
</script>
@endpush