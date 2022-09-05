<div class="modal fade savemodel" tabindex="-1" role="dialog" id="savemodel" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload New Model</h5>
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
                                    <label for="process_experiment_name">Model Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" id="model_name" name="model_name" required placeholder="Enter Model Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="model_type">Select Model Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Model Type"></i></span>
                                    </label>
                                    <select data-width="100%" class="form-control" id="model_type" name="model_type" required>
                                        <option value="0">Select Model Type</option>
                                        <option value="1">Experiment Configuration Model</option>
                                        <option value="2">Unit Model</option>
                                        <option value="3">Variable Model</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="version">Version
                                        <i data-toggle="tooltip" title="Enter version." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text"  data-request="isnumeric" class="form-control" id="version" name="version" placeholder="Enter Version">
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label for="association">Association
                                        <i data-toggle="tooltip" title="Enter Association." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="tags-style" id="association" name="association" />
                                </div> --}}
                                {{-- <div class="form-group col-md-6">
                                    <label for="association">Recommendations
                                        <i data-toggle="tooltip" title="Enter Recommendations." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="tags-style" id="recommendations" name="recommendations" />
                                </div> --}}
                                {{-- <div class="form-group col-md-6">
                                    <label for="association">List of Models
                                        <i data-toggle="tooltip" title="Enter List of Models." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="tags-style" id="list_of_models" name="list_of_models" />
                                </div> --}}
                                {{-- <div class="form-group col-md-6">
                                    <label for="association">Assumptions
                                        <i data-toggle="tooltip" title="Enter Association." class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <input type="text" class="tags-style" id="assumptions" name="assumptions" />
                                </div> --}}
                                {{-- <div class="form-group col-md-6">
                                    <label for="tags">Tags
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                                    </label>
                                    <input type="text" id="tags" class="tags-style" name="tags" placeholder="Enter tags">
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label for="image">Upload File
                                        <i data-toggle="tooltip" title="upload_image. Maximum file size is 1 MB" class="icon-sm" data-feather="info" data-placement="top"></i>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" multiple="multiple" class="custom-file-input" id="associted_model_file" name="associted_model_file">
                                        <label class="custom-file-label" for="image">Choose File</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="description">Description
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                                    </label>
                                    <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">Clear</button>
                    <button type="button" onclick="saveAsso()" class="btn btn-sm btn-secondary">
                        <span id="spnid" class="spinner-border spinner-border-sm" style="display: none;"></span>
                        Request</button>
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
    $('#assumptions').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });
    $('#association').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });
    $('#list_of_models').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });
    $('#recommendations').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });

    function saveAsso() {
        $("#spnid").show();
        var fd = new FormData();
        var totalfiles = document.getElementById('associted_model_file').files.length;
        //   var files = $('#associted_model_file')[0].files;
        var model_name = $('#model_name').val();
        if (model_name == "") {
            swal.fire({
                text: "Enter Model Name",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            $("#spnid").hide();
            return false;
        }
        var model_type = $('#model_type').val();
        var exp_configuration = $('#exp_configuration').val();
        var tags = $('#tags').val();
        var association = $('#association').val();
        var recommendations = $('#recommendations').val();
        var list_of_models = $('#list_of_models').val();
        var description = $('#description').val();
        var assumptions = $('#assumptions').val();
        var version = $('#version').val();


        // Check file selected or not
        if (totalfiles > 0) {
            for (var index = 0; index < totalfiles; index++) {
                fd.append("associted_model_file[]", document.getElementById('associted_model_file').files[index]);
            }
        }
        //  fd.append('associted_model_file', files[0]);
        fd.append('model_name', model_name);
        fd.append('model_type', model_type);
        fd.append('exp_configuration', exp_configuration);
        fd.append('tags', tags);
        fd.append('description', description);
        fd.append('process_experiment_id', process_experiment_id);
        fd.append('association', association);
        fd.append('list_of_models', list_of_models);
        fd.append('assumptions', assumptions);
        fd.append('version', version);
        fd.append('recommendations', recommendations);
        fd.append('vartion_id', vartion_id);
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/process_exp_associated') }}",
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#savemodel").modal('hide');
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
                $("#spnid").hide();
            },

        });


    }
</script>