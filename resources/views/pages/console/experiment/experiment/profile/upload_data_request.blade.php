<div class="modal fade savedatarequest" tabindex="-1" role="dialog" id="savedatarequest" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload new model update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="card-body">
                            @CSRF
                            <div class="form-row">
                                {{-- <div class="form-group col-md-6">
                                    <label for="model_type">Select Data Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip"
                                                data-placement="top" title="Select Data Type"></i></span>
                                    </label>
                                    <select data-width="100%" class="form-control" id="data_type" name="data_type"
                                        required>
                                        <option value="0">Select Data Type</option>
                                        <option value="1">Experiment Variation Model</option>
                                        <!-- <option value="2">Unit Model</option>
                    <option value="3">Variable Model</option> -->
                                        <option value="4">Dataset</option>
                                        <!-- <option value="5">LCA Report</option>
                    <option value="6">Simulation Report</option>
                    <option value="7">Miscalleneous</option>
                    <option value="8">Update Dataset with a New Variable</option> -->
                                    </select>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label for="model_type">Select Model Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Model Name"></i></span>
                                    </label>
                                    <select data-width="100%" class="form-control" id="model_id" name="model_id" required>
                                        <option value="0">Select Model Name</option>
                                        @if (!empty($models))
                                        @foreach ($models as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="model_type">Select Dataset Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Dataset Name"></i></span>
                                    </label>
                                    <select data-width="100%" class="form-control" id="simulation_input_id" name="simulation_input_id" required>
                                        <option value="0">Select Dataset Name</option>
                                        @if (!empty($datasets))
                                        @foreach ($datasets as $dataset)
                                        <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label for="data_req_file">Upload File
                                        <i data-toggle="tooltip" title="upload_image. Maximum file size is 1 MB" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="data_req_file" name="data_req_file">
                                        <label class="custom-file-label" for="data_req_file">Choose File</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                                    </label>
                                    <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                </div> --}}
                                <div class="form-group col-md-12">
                                    <label for="description"> Notes
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Notes"></i></span>
                                    </label>
                                    <textarea name="description" id="file_notes" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="saveRequest()" class="btn btn-sm btn-secondary">
                        <span id="spnid" class="spinner-border spinner-border-sm" style="display: none;"></span>
                        Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#tags').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });

    function saveRequest() {
        $("#spnid").show();
        var fd = new FormData();
        //  var files = $('#data_req_file')[0].files;
        var simulation_input_id = $('#simulation_input_id').val();
        var model_id = $('#model_id').val();
        if (model_id == 0) {
            swal.fire({
                text: "Please Select Model",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            $("#spnid").hide();
            return false;
        }
        if (simulation_input_id == 0) {
            swal.fire({
                text: "Please Select Dataset",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            $("#spnid").hide();
            return false;
        }
        //var description = $('#description').val();
        var file_notes = $('#file_notes').val();
        // Check file selected or not
        // if (files.length > 0) {
        //fd.append('data_req_file', files[0]);
        fd.append('simulation_input_id', simulation_input_id);
        fd.append('model_id', model_id);
        fd.append('file_notes', file_notes);
        //    fd.append('description', description);
        fd.append('process_experiment_id', process_experiment_id);
        fd.append('vartion_id', vartion_id);
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/process_exp_datarequest') }}",
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#savedatarequest").modal('hide');
                $("#spnid").hide();
                if (response.success == true) {
                    $('#datarequest_list_tab').trigger('click')
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timer: 5000,
                    });
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timer: 5000,
                    });
                    Toast.fire({
                        icon: 'warning',
                        title: response.message,
                    })
                }
            },
        });
        // } else {
        //   swal.fire({
        //        text: "Please Select File To Upload",
        //       confirmButtonText: 'Close',
        //        confirmButtonClass: 'btn btn-sm btn-danger',
        //        width: '350px',
        //       height: '10px',
        //        icon: 'warning',
        //    });
        //     $("#spnid").hide();
        //   return false;
        //}
    }
</script>