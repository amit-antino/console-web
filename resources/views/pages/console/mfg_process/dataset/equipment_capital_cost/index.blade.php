<div class="tab-pane fade show " id="process_first_equipment" role="tabpanel" aria-labelledby="process_first_equipment-tab">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5>Process Plant Size</h5>
            </div>
            @if($viewflag!='view_config')
            <button type="button" onclick="capitalCostModel()" class="btn btn-sm btn-icon-text btn-secondary">
            <i class="fas fa-plus"></i>Add Equipment Capital Cost</button>
            @endif
        </div>
        <div class="card-body row">
            <div class="col-md-12 table-responsive">
                <table class="table table-hover mb-0" id="e3stream-data">
                    <thead>
                        <th>Product plant size</th>
                        <th>Flowtype</th>
                        <th>PPS Reference</th>
                        <th>Capex Estimate</th>
                        <th>Capex Reference</th>
                        <th>Is Recomended</th>
                        @if($viewflag!='view_config')
                        <th>Action</th>
                        @endif
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($process_dataset['equipment_capital_cost']['equipment_capital_cost'])) {
                            $capCount = count($process_dataset['equipment_capital_cost']['equipment_capital_cost']);
                        } else {
                            $capCount = 0;
                        }
                        ?>
                        @if(!empty($process_dataset['equipment_capital_cost']))
                        @foreach($process_dataset['equipment_capital_cost']['equipment_capital_cost'] as $ck=>$cv)
                        <tr>
                            <td>
                                {{$cv['process_plant_size']}}
                                @if(!empty($data['capitalcost_unit']))
                                @foreach($data['capitalcost_unit'] as $mkk =>$mvv)
                                @if($cv['pps_unit']==$mkk)
                                {{$mvv}}
                                @endif
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if(!empty($data['capitalcost_flowtype']))
                                
                                @foreach($data['capitalcost_flowtype'] as $fk =>$fv)
                                @if($cv['flowtype_id']==$fk)
                                {{$fv}}
                                @endif
                                @endforeach
                                @endif
                            </td>
                            <td>
                                {{$cv['pps_reference']}}
                            </td>
                            <td>
                                {{$cv['capex_estimate']}}

                                @if($cv['capex_price_unit'] == "1")
                                <span>US $</span>
                                @else
                                <span>Euro</span>
                                @endif
                            </td>
                            <td>
                                {{$cv['capex_reference']}}
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch{{$ck}}" onchange="isRecom('{{$ck}}')" @if($cv['is_default']=='1' ) checked @endif @if($viewflag=='view_config') disabled @endif>
                                        <label class="custom-control-label" for="customSwitch{{$ck}}"></label>
                                    </div>
                            </td>
                            @if($viewflag!='view_config')
                            <td>
                                <a href="javascript:void(0);" onclick="eidtCapitalmodel('{{$ck}}')" class="btn btn-icon " data-toggle="tooltip" data-placement="bottom" title="Edit Data">
                                    <i class="fas fa-edit  text-secondary"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="deleteCapitalmodel('{{$ck}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                                    <i class="fas fa-trash  text-secondary"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7">NO Records Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="add_cp_append">
</div>

<script>
 process_id = document.getElementById('txtid').value;
 dataset_id = '{{___encrypt($process_dataset["id"])}}';
function capitalCostModel() {
objectexp = {};
event.preventDefault();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var url = "{{URL('/mfg_process/simulation/getcapitalCost')}}";
$.ajax({
    type: 'POST',
    url: url,
    data: JSON.stringify(objectexp),
    cache: false,
    contentType: false,
    processData: false,
    success: function(result) {
        $("#add_cp_append").html(result);
        $(".capital_cost_model").modal("show");
    },
});
}

function getpps(val) {

if (val == 0) {
    document.getElementById('pps_').value = "";
    document.getElementById('ppsid_').value = "";
    return false;
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
$.ajax({
    url: "{{ url('/mfg_process/simulation/getpps') }}",
    method: 'POST',
    data: {
        "flowtype": val,
        "process_id": process_id,
       // "simulation_type": simulation_type,
    },
    success: function(result) {
        var obj = JSON.parse(result);
        console.log(obj);
        document.getElementById('pps_').value = obj['name'];
        document.getElementById('ppsid_').value = obj['id'];
    }
});
}

function capitalCostSave() {

var count = '<?php echo $capCount; ?>';
var elementjson = {
    "id": count,
    "process_plant_size": document.getElementById('ecc_id').value,
    "pps_unit": document.getElementById('pps_unit').value,
    "pps_unit_type": "10",
    "flowtype_id": document.getElementById('basic').value,
    "pps_refrence_id": document.getElementById('ppsid_').value,
    "pps_reference": document.getElementById('pps_').value,
    "capex_estimate": document.getElementById('capex_estimate').value,
    "capex_reference": document.getElementById('capex_reference').value,
    "capex_price_unit": document.getElementById('price').value,
    "capex_price_unit_type": "19",
    "is_default": document.getElementById('is_default').value
};


var objJson = [];

objJson.push(elementjson);
var objectWiz = {
    "dataset_id": dataset_id,
    "cap": "capital",
    "capital_cost_eqp": objJson,
    "getAction": document.getElementById('getAction').value,
    "capId": document.getElementById('capId').value,
};
event.preventDefault();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    type: 'POST',
    url: "{{ url('/mfg_process/simulation/dataset/capitalCostSave')}}",
    data: JSON.stringify(objectWiz),
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {
        if (data.success === true) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: data.message,
            })
            $('#equipment_capital_cost').trigger('click');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.errors,
            })
        }
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $("#add_cp_append").html('');
        $(".capital_cost_model").modal("hide");
        $("#equipment-tab").addClass("active");

    },
});
}

function eidtCapitalmodel(cap_id) {

var objectexp = {
    "dataset_id": dataset_id,
    "capid": cap_id,
};
event.preventDefault();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var url = "{{URL('/mfg_process/simulation/dataset/capitalCostEditModel')}}";
$.ajax({
    type: 'POST',
    url: url,
    data: JSON.stringify(objectexp),
    cache: false,
    contentType: false,
    processData: false,
    success: function(result) {
        $("#add_cp_append").html(result);
        $(".capital_cost_model").modal("show");
    },
});
}


function deleteCapitalmodel(cap_id) {

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false,
})
swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You Want to Delete?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'ml-2',
    confirmButtonText: 'Yes!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
}).then((result) => {
    if (result.value) {
        var objectWiz = {
            "dataset_id": dataset_id,
            "cap": "capital",
            "getAction": "delete",
            "capId": cap_id,
        };
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ url('/mfg_process/simulation/dataset/capitalCostSave')}}",
            data: JSON.stringify(objectWiz),
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success === true) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: "Process Simulation profile successfully Deleted",
                    })
                    $('#equipment_capital_cost').trigger('click');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.errors,
                    })
                }
                $("#equipment-tab").addClass("active");

            },
        });
        swalWithBootstrapButtons.fire(
            'Added!',
            ' Master Data Added .',
            'success'
        )
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
            'Cancelled',
            '',
            'error'
        )
        $("#equipment-tab").addClass("active");
    }
})
}

function isRecom(capid) {
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false,
})
swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You Want to Is_Recomended?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'ml-2',
    confirmButtonText: 'Yes!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
}).then((result) => {
    if (result.value) {
        var objectWiz = {
            "dataset_id": dataset_id,
            "cap": "capital",
            "getAction": "isrecomended",
            "capId": capid,
        };
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ url('/mfg_process/simulation/dataset/capitalCostSave')}}",
            data: JSON.stringify(objectWiz),
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success === true) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: "Status update successfully",
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.errors,
                    })
                }
                $( "#equipment_capital_cost" ).trigger( "click" );
                $("#equipment-tab").addClass("active");
            },
        });
        swalWithBootstrapButtons.fire(
            'Added!',
            ' Master Data Added .',
            'success'
        )
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
            'Cancelled',
            '',
            'error'
        )
        $("#equipment-tab").addClass("active");
    }
})
}
</script>
