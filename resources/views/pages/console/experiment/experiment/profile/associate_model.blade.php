<div class="table-responsive">
    <table id="" class="table">
        <thead>
            @if ($viewflag != 'view')
                <th>
                    <input type="checkbox" name="example-select-all_model" value="1" id="example-select-all_model">
                </th>
            @endif
            <th class="">Model name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Requested Date</th>
            <th >Operational Status</th>
            <th >Status</th>
            @if ($viewflag != 'view')
                <th class="text-center">Actions</th>
            @endif
        </thead>
        <tbody>
            @php
                $per = request()->get('sub_menu_permission');
                $permission = !empty($per['models']['method']) ? $per['models']['method'] : [];
            @endphp
            @if (!empty($data))
                @foreach ($data as $val)
                    <tr>

                        @if ($viewflag != 'view')
                            <td><input type="checkbox" value="{{ ___encrypt($val['id']) }}" class="checkSingle_model"
                                    name="select_all_model[]"></td>
                        @endif
                        <td>{{ $val['name'] }}</td>
                        <td>
                            @if ($val['model_type'] == 1)
                                Experiment Configuration Model
                            @elseif($val['model_type']==2)
                                Unit Model
                            @elseif($val['model_type']==3)
                                Variable Model
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            {{ $val['description'] }}
                        </td>
                        <td>
                             {{ $val['created_at'] }}
                        </td>
                        <td>
                            @php
                                $status = str_replace('_',' ',$val['status']);
                            @endphp
                            {{ucfirst($status)}}
                        </td>
                        <td class="text-center">
                           
                            {{ucfirst($val['operation_status'])}}
                        </td>
                        @if ($viewflag != 'view')
                            <td class="text-center">
                                @php
                                    $mid = ___encrypt($val['id']);
                                @endphp

                                {{-- <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip"
                                    data-placement="bottom" title="Edit Model" @if (in_array('edit', $permission))
                                    onclick="editModel('{{ $mid }}')"
                                @else
                                    data-request="ajax-permission-denied"
                        @endif
                        >
                        <i class="fas fa-edit text-secondary"></i>
                        </a> --}}

                        <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip"
                            data-placement="bottom" title="Delete Model" @if (in_array('delete', $permission))
                            onclick=" deleteModel('{{ ___encrypt($val->id) }}')"
                        @else
                            data-request="ajax-permission-denied"
                @endif
                >
                <i class="fas fa-trash text-secondary"></i>
                </a>
                </td>
            @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    function changestatus(val, id, pe_id) {

        $('#expprofileSpinner').show();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to update status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/experiment/experiment/status_associate_model') }}",
                    method: 'POST',
                    data: {
                        pe_id: pe_id,
                        model_id: id,
                        val: val

                    },
                    success: function(result) {
                        $('#associated_models_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Model Deleted",
                        })

                        $('#expprofileSpinner').hide();

                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Model Deleted .',
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
                $('#associated_models_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })
    }

    function editModel(id) {

        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/render_edit_models') }}",
            method: 'post',
            data: {
                model_id: id,

            },

            success: function(result) {
                $('#render_edit_models').html(result.html);
                $('#expprofileSpinner').hide();
                $("#editassociatedModal" + id).modal('show');

            }
        });
    }

    function deleteModel(id) {
        $('#expprofileSpinner').show();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to delete?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/experiment/experiment/delete_associate_model') }}",
                    method: 'POST',
                    data: {
                        id: id,

                    },
                    success: function(result) {
                        $('#associated_models_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Model Deleted",
                        })

                        $('#expprofileSpinner').hide();

                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Model Deleted .',
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
                $('#associated_models_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })




    }

    function bulkdelModeldetail() {

        var len = $("[name='select_all_model[]']:checked").length;
        if (len == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        var values = $("input[name='select_all_model[]']:checked")
            .map(function() {
                return $(this).val();
            })
            .get();

        $('#expprofileSpinner').show();
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

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/experiment/model/bulkdelmodel') }}",
                    method: 'POST',
                    data: {
                        ids: values,
                    },
                    success: function(result) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: " Deleted",
                        })
                        $('#associated_models_tab').trigger('click')
                        $('#expprofileSpinner').hide();

                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Deleted .',
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
                $('#associated_models_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })


    }
    $(".deletebulk_model").hide();
    $("#example-select-all_model").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_model").show();
        } else {
            $(".deletebulk_model").hide();
        }
        $('.checkSingle_model').not(this).prop('checked', this.checked);
        $('.checkSingle_model').click(function() {

            if ($('.checkSingle_model: checked ').length == $('.checkSingle_model').length) {
                $('#example-select-all_model').prop('checked', true);
            } else {
                $('#example-select-all_model').prop('checked', false);
            }
        });
    });
    $('.checkSingle_model').click(function() {
        var len = $("[name='select_all_model[]']:checked").length;

        if (len >= 1) {
            $(".deletebulk_model").show();
        } else {
            $(".deletebulk_model").hide();
        }
    });
</script>
