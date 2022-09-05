<div class="modal fade bd-product-modal-lg" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{url('/product_system/profile')}}" method="POST" role="product_sys_profile">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Product System : </h4>
            </div>
            <div class="card-body">
                @CSRF
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="process">Select Process
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process"></i></span>
                        </label>
                        <select id="SimProduct" name="SimPrcess" class="SimProduct" onchange="SimProducts(this.value)">
                            <option id="0">Select Process</option>
                            @if(!empty($data['process']))
                            @foreach($data['process'] as $pval)
                            <option value="{{$pval['id']}}">{{$pval['process_name']}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="process">Process Number
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Process Number"></i></span>
                        </label>
                        <input type="text" disabled class="form-control" style="background-color:white ;" value="1">
                        <input type="text" class="form-control" style="background-color:white ;" value="{{$data['id']}}" name="prd_system" id="prd_system">
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <label for="prd_input">Select Product Input
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Type"></i></span>
                                </label>
                                <select id="prdInput" name="prdInput[]" class="prdInput">
                                    <option value="0">Select Product Input</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                </br>
                                <button type="button" class="btn btn-sm btn-secondary btn-icon" id="btnadd" data-toggle="tooltip" data-placement="bottom" title="Add">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="form-group col-md-1">
                                <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                </br>
                                <button type="button" disabled class="btn btn-sm btn-danger btn-icon" id="btndel" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="procees_prdInput" id="procees_prdInput"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <label for="prd_output">Select Product Output
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Type"></i></span>
                                </label>
                                <select id="prdOut" name="prdOut[]" class="js-example-basic-single w-100 prdOut">
                                    <option value="0">Select Product Output</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                </br>
                                <button type="button" class="btn btn-sm btn-secondary btn-icon" id="btnaddoutput" data-toggle="tooltip" data-placement="bottom" title="Add">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="form-group col-md-1">
                                <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                </br>
                                <button type="button" disabled class="btn btn-sm btn-danger btn-icon" id="btndeloutput" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="procees_prdOutput" id="procees_prdOutput"></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="product_sys_profile"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{url('product_system/product')}}" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });

    function SimProducts(val) {
        // alert("prdInempty");
        prd_system = document.getElementById('prd_system').value;
        $('.prdInput')
            .empty().append('<option  value="">Select Product Input</option>');
        $('.prdOut')
            .empty().append('<option  value="">Select Product output</option>');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/product_system/product/simulationproduct') }}",
            method: 'GET',
            data: {
                id: val,
                prd_id: prd_system
            },
            success: function(result) {
                respObj = JSON.parse(result);
                if (respObj['err']) {
                    swal.fire({
                        text: respObj['err'],
                        confirmButtonText: 'Close',
                        confirmButtonClass: 'btn btn-sm btn-danger',
                        width: '350px',
                        height: '10px',
                        icon: 'warning',
                    });
                    return false;
                }
                for (obj in respObj) {
                    if (respObj[obj].length != 0) {
                        $('.prdInput').append($('<option>', {
                            value: respObj[obj]['id'],
                            text: respObj[obj]['product']
                        }));
                        $('.prdOut').append($('<option>', {
                            value: respObj[obj]['id'],
                            text: respObj[obj]['product']
                        }));
                    }
                }
            }
        });
    }

    $(document).on('click', '#btnadd', function() {
        var html = '';
        html += '<div id="prdInputFormUnit">';
        html += '<div class="form-row">';
        html += '<div class = "form-group col-md-10" >';
        html += '<select id = "prdInput" name = "prdInput[]" class = "js-example-basic-single prdInput">';
        html += '<option value = "0" > Select Product Input </option> </select>';
        html += '</div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button" class = "btn btn-sm btn-secondary btn-icon" id = "btnadd" data - toggle = "tooltip" data - placement = "bottom" title = "Add">';
        html += '<i class = "fa fa-plus" > </i> </button> </div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button"  class = "btn btn-sm btn-danger btn-icon" id = "btndel" data - toggle = "tooltip" data - placement = "bottom" title = "Delete" >';
        html += '<i class = "fa fa-minus" > </i> </button> </div> </div>';
        html += '<div class="procees_prdInput" id="procees_prdInput"></div>';
        html += '</div>';
        $('#procees_prdInput').append(html);
    });

    $(document).on('click', '#btndel', function() {
        $(this).closest('#prdInputFormUnit').remove();
    });

    $(document).on('click', '#btnaddoutput', function() {
        var html = '';
        html += '<div id="prdOutputFormUnit">';
        html += '<div class="form-row">';
        html += '<div class = "form-group col-md-10" >';
        html += '<select id = "prdOut" name = "prdOut[]" class = "js-example-basic-single prdOut">';
        html += '<option value = "0" > Select Product Output </option> </select>';
        html += '</div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button" class = "btn btn-sm btn-secondary btn-icon" id = "btnaddoutput" data - toggle = "tooltip" data - placement = "bottom" title = "Add">';
        html += '<i class = "fa fa-plus" > </i> </button> </div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button"  class = "btn btn-sm btn-danger btn-icon" id = "btndeloutput" data - toggle = "tooltip" data - placement = "bottom" title = "Delete" >';
        html += '<i class = "fa fa-minus" > </i> </button> </div> </div>';
        html += '<div class="procees_prdOutput" id="procees_prdOutput"></div>';
        html += '</div>';
        $('#procees_prdOutput').append(html);
    });

    $(document).on('click', '#btndeloutput', function() {
        $(this).closest('#prdOutputFormUnit').remove();
    });
</script>
@endpush