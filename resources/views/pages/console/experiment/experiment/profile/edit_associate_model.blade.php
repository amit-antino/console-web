<div class="modal fade bd-example-modal-lg" id="editassociatedModal{{___encrypt($data['id'])}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Update Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="card-body">
                            @CSRF
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="model_type">Select Model Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Model Type"></i></span>
                                    </label>
                                    <input  type="text" value="{{$data->name}}" class="form-control" id="associated_edit_md" name="associated_edit_md" required placeholder="Enter Model Name">
                                    <input type="hidden" value="{{___encrypt($data->id)}}" id="edit_model_id" name="edit_model_id">
                                </div>
                                <div class="col-md-6" id="">
                                    <label for="model_type">Select Model File
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Model File"></i></span>
                                    </label>
                                    <div id="render_edit_models_file">
                                        <select data-width="100%" class="form-control" id="associated_edit_file" name="associated_edit_file" required>
                                            <option value="">Select File</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" id="file_data">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" onclick="updateAsso()" class="btn btn-sm btn-secondary">
                        <span id="spnid" class="spinner-border spinner-border-sm" style="display: none;"></span>
                        Save edited model</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    if ($('#ace_html').length) {
        $(function() {
            var editor = ace.edit("ace_html");
            editor.setTheme("ace/theme/dracula");
            editor.getSession().setMode("ace/mode/html");
            editor.setOption("showPrintMargin", false)
        });
    }
    var mid = '<?php echo ___encrypt($data['id']); ?>';
    getFileById(mid);

    function getFileById(id) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/get_models_file')}}",
            method: 'post',
            data: {

                id: id,

            },
            success: function(result) {
                $('#render_edit_models_file').html(result.html);
                $('#expprofileSpinner').hide();

            }
        });
    }

    function getFileContent(id) {
        $('#expprofileSpinner').show();
        var mid = document.getElementById('mid').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/getFileContent_models')}}",
            method: 'post',
            data: {
                id: mid,
                file_id: id,

            },
            success: function(result) {
                $('#file_data').html(result.html);
                $('#expprofileSpinner').hide();

            }
        });
    }
    //getFileContent
    function updateAsso() {
        $("#spnid").show();
        var fd = new FormData();
        var id = $('#mid').val();
        var name = $('#associated_edit_md').val();

        var textarea = ace.edit("ace_html");
        fd.append('id', id);
        fd.append('name', name);
        fd.append('file_content', textarea.getValue());
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/update_associated_model') }}",

            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                var edit_model_id = $('#edit_model_id').val();
                $("#editassociatedModal" + edit_model_id).modal('hide');
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
                        title: "Model Added",
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
                        title: "File Not Uploaded",
                    })
                }
                $("#spnid").hide();
            },
        });
        //  } else {
        //      swal.fire({
        //          text: "Please Enter Variation Name",
        //          confirmButtonText: 'Close',
        //          confirmButtonClass: 'btn btn-sm btn-danger',
        //          width: '350px',
        //          height: '10px',
        //          icon: 'warning',
        //      });
        //      return false;
        //  }
    }
</script>