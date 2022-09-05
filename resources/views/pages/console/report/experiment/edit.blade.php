<div class="modal fade bd-example-modal-lg" id="editconfigModal{{___encrypt($process_experiment_report['id'])}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Edit Report Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="process_experiment">Enter Report Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Report Name"></i></span>
                            </label>
                            <input type="text" value="{{$process_experiment_report['name']}}" id="edit_report_name" name="edit_report_name" class="form-control" placeholder="Report Name">
                            <span id="error-msg-rpe" class="help-block text-danger"></span>

                            <input type="hidden" value="{{___encrypt($process_experiment_report['id'])}}" id="edit_report_id" name="edit_report_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" onclick="updateReportname()" class="btn btn-sm btn-secondary submit">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateReportname() {
        var fd = new FormData();
        var edit_report_name = $('#edit_report_name').val();
        var edit_report_id = $('#edit_report_id').val();
        if (edit_report_name != "") {
            fd.append('edit_report_name', edit_report_name);
            fd.append('edit_report_id', edit_report_id);
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/reports/experiment/updateName') }}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success == true) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        });
                        $("#editconfigModal" + edit_report_id).modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        let url = "{{ url('reports/experiment') }}";
                        document.location.href = url;
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 10000,
                        });
                        Toast.fire({
                            icon: 'failure',
                            title: "report not Updated",
                        });
                    }
                },
            });
        } else {
            $("#error-msg-rpe").text("Please add report name");
            return false;
        }
    }
</script>