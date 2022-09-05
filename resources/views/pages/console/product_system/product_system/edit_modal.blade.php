<div class="modal fade mymodel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="mymodal{{$data['prd_pf']['id']}}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{url('/product_system/profile/'.___encrypt($data['prd_pf']['id']))}}" method="POST" role="product_sys_profile_edit">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
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
                                    <option {{($pval['id'] == $data['prd_pf']['process_id'] ) ? "selected" : "" }} value="{{$pval['id']}}">{{$pval['process_name']}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="hidden" style="background-color:white ;" value="{{$data['prd_pf']['product_system_id']}}" name="prd_system" id="prd_system">
                            </div>
                            <div class="form-group col-md-6 select-input">
                                <label for="prd_input">Select Product Input
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product Input"></i></span>
                                </label>
                                @foreach($data['prd_pf']['product_input'] as $k =>$v)
                                <div id="prdInputFormUnitedit">
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <select id="prdInput" name="prdInput[]" class="prdInput" onchange="prdInputvalidation(this.value,this)">
                                            @if(!empty($data['inpout']))
                                            @foreach($data['inpout'] as $io =>$iov)
                                            <option {{($v == $iov['id']  ) ? "selected" : "" }} value="{{$iov['id']}}">{{$iov['product']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="button" class="btn btn-sm text-secondary " id="btnaddedit" data-toggle="tooltip" data-placement="bottom" title="Add">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="button" class="btn btn-sm text-secondary " id="btndeledit" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                </div>
                                @endforeach
                                <div class="procees_prdInput" id="procees_prdInput_edit"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prd_output">Select Product Output
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Type"></i></span>
                                </label>
                                @foreach($data['prd_pf']['product_output'] as $ko =>$vo)
                                <div id="prdOutputFormUnit_edit">
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <select id="prdOut" name="prdOut[]" class="js-example-basic-single w-100 prdOut"  onchange="prdOutputvalidation(this.value, this)">
                                            @if(!empty($data['inpout']))
                                            @foreach($data['inpout'] as $io =>$iov)
                                            <option {{($vo == $iov['id']  ) ? "selected" : "" }} value="{{$iov['id']}}">{{$iov['product']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="button" class="btn btn-sm text-secondary btn-icon" id="btnaddeditoutput" data-toggle="tooltip" data-placement="bottom" title="Add">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="button" class="btn btn-sm text-secondary btn-icon" id="btndeleditoutput" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                </div>
                                @endforeach
                                <div class="procees_prdOutput_edit" id="procees_prdOutput_edit"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="product_sys_profile_edit"]' class="btn btn-sm btn-secondary submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var objInput = '<?php echo json_encode($data['inpout']) ?>';
    objInputparse = JSON.parse(objInput);
    $(document).on('click', '#btnaddedit', function() {

        if (typeof objInputparse === 'undefined') {

            return false;
        }
        //console.log(objInputparse);
        var html = '';
        html += '<div id="prdInputFormUnitedit">';
        html += '<div class="form-row">';
        html += '<div class = "form-group col-md-10" >';
        html += '<select id = "prdInput" name = "prdInput[]" class = "prdInput" onchange="prdInputvalidation(this.value,this)">';
        html += '<option value = "0" > Select Product Input </option>';
        if (objInputparse) {

            for (i in objInputparse) {
                html += '<option value="' + objInputparse[i]['id'] + '">' + objInputparse[i]['product'] + '</option>';
            }

        }
        html += '</select>';
        html += '</div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button" class = "btn btn-sm text-secondary btn-icon" id = "btnaddedit" data - toggle = "tooltip" data - placement = "bottom" title = "Add">';
        html += '<i class = "fa fa-plus" > </i> </button> </div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button"  class = "btn btn-sm text-secondary btn-icon" id = "btndeledit" data - toggle = "tooltip" data - placement = "bottom" title = "Delete" >';
        html += '<i class = "fa fa-minus" > </i> </button> </div> </div>';
        html += '<div class="procees_prdInput_edit" id="procees_prdInput_edit"></div>';
        html += '</div>';
        $('#procees_prdInput_edit').append(html);
    });

    $(document).on('click', '#btndeledit', function() {
        $(this).closest('#prdInputFormUnitedit').remove();
    });

    $(document).on('click', '#btnaddeditoutput', function() {
        if (typeof objInputparse === 'undefined') {

            return false;
        }
        var html = '';
        html += '<div id="prdOutputFormUnit_edit">';
        html += '<div class="form-row">';
        html += '<div class = "form-group col-md-10" >';
        html += '<select id = "prdOut" name = "prdOut[]" class = "prdOut" onchange="prdInputvalidation(this.value,this)">';
        html += '<option value = "0" > Select Product Output </option>';
        if (objInputparse) {

            for (i in objInputparse) {
                html += '<option value="' + objInputparse[i]['id'] + '">' + objInputparse[i]['product'] + '</option>';
            }

        }
        html += '</select>';
        html += '</div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button" class = "btn btn-sm text-secondary btn-icon" id = "btnaddeditoutput" data - toggle = "tooltip" data - placement = "bottom" title = "Add">';
        html += '<i class = "fa fa-plus" > </i> </button> </div>';
        html += '<div class = "form-group col-md-1">';
        html += '<button type = "button"  class = "btn btn-sm text-secondary btn-icon" id = "btndeleditoutput" data - toggle = "tooltip" data - placement = "bottom" title = "Delete" >';
        html += '<i class = "fa fa-minus" > </i> </button> </div> </div>';
        html += '<div class="procees_prdOutput_edit" id="procees_prdOutput_edit"></div>';
        html += '</div>';
        $('#procees_prdOutput_edit').append(html);
    });

    $(document).on('click', '#btndeleditoutput', function() {
        $(this).closest('#prdOutputFormUnit_edit').remove();
    });

    selected=[];
    $('.prdInput :selected').each(function() {
        if ($(this).val() != "")
            selected.push($(this).val());
    });

    selectedOut = [];
    $('.prdOut :selected').each(function() {
        if ($(this).val() != "")
            selectedOut.push($(this).val());
    });
</script>