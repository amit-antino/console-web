<div class="modal fade bd-example-modal-lg" id="editconfigModal{{___encrypt($process_experiment_info['variation_id'])}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/experiment/variation/updateVarition') }}" method="POST" role="edit_process_config">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Edit Experiment Variation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Variation Name
                            <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Variation Name"></i></span>
                            </label>
                            <input type="text" id="variation_edit_name" name="variation_name" class="form-control" value="{{($process_experiment_info['config_name'])}}" placeholder="Variation Name">
                            <input type="hidden" id="var_experiment_id" name="var_experiment_id" class="form-control" value="{{___encrypt($process_experiment_info['id'])}}">
                            <input type="hidden" id="var_id" name="var_id" class="form-control" value="{{___encrypt($process_experiment_info['variation_id'])}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea name="description" id="var_description" rows="5" class="form-control">
                            {{($process_experiment_info['config_description'])}}
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                <button type="button" id="submit_button_id" data-request="ajax-submit"  data-target='[role="edit_process_config"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <!-- <button type="button" onclick="updateCurrentConfig()" class="btn btn-sm btn-secondary submit">Submit</button> -->
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCurrentConfig() {
        var fd = new FormData();
        var variation_name = $('#variation_edit_name').val();
        var experiment_id = $('#var_experiment_id').val();
        var var_id = $('#var_id').val();
        var config_description = $('#var_description').val();
        if (variation_name != "") {
            fd.append('variation_name', variation_name);
            fd.append('experiment_id', experiment_id);
            fd.append('description', config_description);
            fd.append('id', var_id);
            console.log(fd);
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/experiment/variation/updateVarition') }}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success == true) {
                        $('#associated_models_tab').trigger('click')
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
                        $("#editconfigModal" + var_id).modal('hide');
                        $('#configuration_view_tab').trigger('click')


                    }
                },
            });
        } else {
            swal.fire({
                text: "Please Enter Variation Name",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            return false;
        }
    }
</script>
