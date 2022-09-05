<div class="table-responsive">
    <table id="" class="table">
        <thead>
            @if ($viewflag != 'view')
                <th><input type="checkbox" name="example-select-all_data_request" value="1"
                        id="example-select-all_data_request"></th>
                </th>
            @endif
            <th>Model Name</th>
            <th>Dataset Name</th>
            <th>Data Request Date</th>
            <th class="text-center">Request Status</th>
            @if ($viewflag != 'view')
                <th class="text-center">Actions</th>
            @endif
        </thead>
        <tbody>
            @php
                $per = request()->get('sub_menu_permission');
                $permission = !empty($per['data_request']['method']) ? $per['data_request']['method'] : [];
            @endphp
            @if (!empty($data))
                @foreach ($data as $val)
                    <tr>

                        @if ($viewflag != 'view')
                            <td><input type="checkbox" value="{{ ___encrypt($val['id']) }}"
                                    class="checkSingle_data_request" name="select_all_data_request[]">
                            </td>
                        @endif
                        <td>
                            {{ get_model_name($val['model_id']) }}
                        </td>
                        <td>
                            {{ get_dataset_name($val['simulation_input_id']) }}
                        </td>
                        <td>{{ dateTimeFormate($val['created_at']) }}</td>
                        <td class="text-center">
                            @php
                                $status = str_replace('_', ' ', $val['status']);
                            @endphp
                            {{ ucfirst($status) }}
                        </td>
                        @if ($viewflag != 'view')

                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete Data/Model Request" @if (in_array('delete', $permission))
                                    onclick="deletedatarequest('{{ ___encrypt($val->id) }}')"
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
    function deletedatarequest(id) {
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
                    url: "{{ url('/experiment/experiment/delete_data_request') }}",
                    method: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(result) {
                        $('#datarequest_list_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Data/Model Request Deleted",
                        });
                        $('#expprofileSpinner').hide();
                    }
                });
                swalWithBootstrapButtons.fire(
                    'Deleted!',
                    ' Data/Model Request Deleted .',
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
                $('#datarequest_list_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        });
    }

    function bulkdelDataRequest() {

        var len = $("[name='select_all_data_request[]']:checked").length;
        if (len == 0) {
            alert("Please select at least one checkbox");
            return false;
        }
        var values = $("input[name='select_all_data_request[]']:checked")
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
                    url: "{{ url('/experiment/data_request/bulkdeldata_request') }}",
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
                        $('#datarequest_list_tab').trigger('click')
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
                $('#datarequest_list_tab').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })


    }
    $(".deletebulk_data_request").hide();
    $("#example-select-all_data_request").click(function() {
        //alert(1);
        if ($(this).is(":checked")) {
            $(".deletebulk_data_request").show();
        } else {
            $(".deletebulk_data_request").hide();
        }
        $('.checkSingle_data_request').not(this).prop('checked', this.checked);
        $('.checkSingle_data_request').click(function() {

            if ($('.checkSingle_data_request: checked ').length == $('.checkSingle_data_request')
                .length) {
                $('#example-select-all_data_request').prop('checked', true);
            } else {
                $('#example-select-all_data_request').prop('checked', false);
            }
        });
    });
    $('.checkSingle_data_request').click(function() {
        var len = $("[name='select_all_data_request[]']:checked").length;

        if (len >= 1) {
            $(".deletebulk_data_request").show();
        } else {
            $(".deletebulk_data_request").hide();
        }
    });
</script>
