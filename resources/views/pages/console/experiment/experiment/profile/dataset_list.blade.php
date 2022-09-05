<div class="table-responsive">
    <table id="" class="table">
        <thead>
            @if ($viewflag != 'view')
                <th><input type="checkbox" name="example-select-all_dataset" value="1" id="example-select-all_dataset">
                </th>
            @endif
            <th>Dataset name</th>
            <th>Upload Date</th>
            <th>Request Date</th>
            <th>Description</th>
            {{-- <th>Tags</th> --}}
            <th class="text-center">Dataset status</th>
            <th class="text-center">Operation status</th>
            {{-- <th class="text-center">Select as default</th> --}}
            @if ($viewflag != 'view')
                <th class="text-center">Actions</th>
            @endif
        </thead>
        <tbody>
            @php
                $per = request()->get('sub_menu_permission');
                $permission = !empty($per['dataset']['method']) ? $per['dataset']['method'] : [];
            @endphp
            @if (!empty($data))
                @foreach ($data as $val)
                    <tr>
                        @if ($viewflag != 'view')
                            <td><input type="checkbox" value="{{ ___encrypt($val['id']) }}" class="checkSingle_dataset"
                                    name="select_all_dataset[]">
                            </td>
                        @endif
                        <td>{{ $val['name'] }}</td>
                        <td>{{ dateTimeFormate($val['updated_at']) }}</td>
                        <td>{{ dateTimeFormate($val['created_at']) }}</td>
                        <td>{{ $val['description'] }}</td>
                        {{-- <td>
                            @if (!empty($val['tags']))
                                @foreach ($val['tags'] as $tag)

                                    <span class="badge badge-info font-weight-normal">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            @endif
                        </td> --}}
                        </td>
                        <td class="text-center">
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
                                    $datasetid = ___encrypt($val['id']);
                                @endphp

                                {{-- <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip"
                                    data-placement="bottom" title="Model Update" @if (in_array('edit', $permission))
                                    onclick="editDataset('{{ $datasetid }}')"
                                @else
                                    data-request="ajax-permission-denied"
                        @endif
                        >
                        <i class="fas fa-edit text-secondary"></i>
                        </a> --}}

                        <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip"
                            data-placement="bottom" title="Delete Dataset" @if (in_array('delete', $permission))
                            onclick="deleteDatasetModel('{{ ___encrypt($val->id) }}')"
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
        @else
            <tr>
                <td colspan="8">No record</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<script>
    function datasetstatus(val, id, pe_id) {

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
            text: "You Want to Update Status?",
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
                    url: "{{ url('/experiment/experiment/status_dataset_model') }}",
                    method: 'POST',
                    data: {
                        pe_id: pe_id,
                        simulation_input_id: id,
                        val: val

                    },
                    success: function(result) {
                        $('#dataset_list_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Model Deleted",
                        });
                        $('#expprofileSpinner').hide();

                    }
                });
                swalWithBootstrapButtons.fire(
                    'Updated!',
                    ' Status Updated .',
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
                $('#dataset_list_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })
    }

    function deleteDatasetModel(id) {
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
                    url: "{{ url('/experiment/experiment/delete_dataset_model') }}",
                    method: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(result) {
                        $('#dataset_list_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Dataset Deleted",
                        });
                        $('#expprofileSpinner').hide();

                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Dataset Deleted .',
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
                $('#dataset_list_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        });
    }

    function bulkdelDataset() {

        var len = $("[name='select_all_dataset[]']:checked").length;
        if (len == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        var values = $("input[name='select_all_dataset[]']:checked")
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
                    url: "{{ url('/experiment/dataset/bulkdeldataset') }}",
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
                        $('#dataset_list_tab').trigger('click')
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
                $('#dataset_list_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })


    }
    $(".deletebulk_dataset").hide();
    $("#example-select-all_dataset").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_dataset").show();
        } else {
            $(".deletebulk_dataset").hide();
        }
        $('.checkSingle_dataset').not(this).prop('checked', this.checked);
        $('.checkSingle_dataset').click(function() {

            if ($('.checkSingle_dataset: checked ').length == $('.checkSingle_dataset').length) {
                $('#example-select-all_dataset').prop('checked', true);
            } else {
                $('#example-select-all_dataset').prop('checked', false);
            }
        });
    });
    $('.checkSingle_dataset').click(function() {
        var len = $("[name='select_all_dataset[]']:checked").length;

        if (len >= 1) {
            $(".deletebulk_dataset").show();
        } else {
            $(".deletebulk_dataset").hide();
        }
    });

    function editDataset(val) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/upload_updated_dataset_model') }}",
            method: 'post',
            data: {
                id: val,
                vartion_id: vartion_id

            },
            success: function(result) {
                $('#render_edit_dataset').html(result.html);
                $("#editdataset" + val).modal('show');
                $('#expprofileSpinner').hide();
            }
        });
    }
</script>
