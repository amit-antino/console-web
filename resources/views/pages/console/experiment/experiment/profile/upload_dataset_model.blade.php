<div class="modal fade savedataset" tabindex="-1" role="dialog" id="savedataset" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload New Dataset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="card-body">
                            @CSRF
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="process_experiment_name">Dataset Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Dataset Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" id="dataset_name" name="dataset_name" required placeholder="Enter Dataset name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="model_type">Select Data Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Model Type"></i></span>
                                    </label>
                                    <select data-width="100%" class="form-control" id="dataset_type" name="dataset_type" required>
                                        <option value="0">Select Data Type</option>
                                        <option value="1">Raw</option>
                                        <option value="2">Template</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tags">Tags
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                                    </label>
                                    <input type="text" id="tags-dataset" class="tags-style" name="tags" placeholder="Enter tags">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description">Description
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                                    </label>
                                    <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image">Upload File
                                        <i data-toggle="tooltip" title="upload_image. Maximum file size is 1 MB" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="dataset_model_file" name="dataset_model_file">
                                        <label class="custom-file-label" for="image">Choose File</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-sm btn-danger">Cancel</button>
                    <button type="button" onclick="savedataset()" class="btn btn-sm btn-secondary">Upload dataset</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#tags-dataset').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });

    function savedataset() {
        var fd = new FormData();
        var files = $('#dataset_model_file')[0].files;
        var dataset_name = $('#dataset_name').val();
        if (dataset_name == "") {
            swal.fire({
                text: "Enter Dataset Name",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            $("#spnid").hide();
            return false;
        }
        var dataset_type = $('#dataset_type').val();
        var tags = $('#tags-dataset').val();
        var description = $('#description').val();
        if (files.length > 0) {
            fd.append('dataset_model_file', files[0]);
        }

        fd.append('dataset_name', dataset_name);
        fd.append('dataset_type', dataset_type);
        fd.append('tags', tags);
        fd.append('description', description);
        fd.append('process_experiment_id', process_experiment_id);
        fd.append('vartion_id', vartion_id);
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/process_exp_dataset') }}",
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#savedataset").modal('hide');
                if (response.success == true) {
                    $('#dataset_list_tab').trigger('click');
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

    }
</script>