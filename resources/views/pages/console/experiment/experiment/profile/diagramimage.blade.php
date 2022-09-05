<div class="modal fade diagramimg" tabindex="-1" role="dialog" aria-labelledby="diagramimg" aria-hidden="true" id="diagramimage{{$data}}">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="exampleModalLabel">Add Process Flow Diagram
                    </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="diagramimg_file">Upload File
                            <i data-toggle="tooltip" title="upload_image. Maximum file size is 1 MB" class="icon-sm" data-feather="info" data-placement="top"></i>
                        </label>
                        <div class="custom-file">
                            <input type="file" class="form-control" id="diagramimg_file" name="diagramimg_file" accept="image/*">
                            <input type="hidden" id="varid" value="{{$data}}">
                            <span class="text-danger" id="file-error">Please choose file</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveimageDiagram()" class="btn btn-sm btn-secondary submit">Submit</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#file-error").hide();
    function saveimageDiagram() {
        var fd = new FormData();
        var files = $('#diagramimg_file')[0].files;
        var varid = $('#varid').val()
        $("#file-error").hide();
        if (files.length > 0) {
            fd.append("diagramimg_file", files[0]);
            fd.append("id", varid);           

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/experiment/process_diagram/saveimgmodel') }}",
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
                        })
                        $('#process_flow_diagram_tab').trigger('click')
                        $("#diagramimage" + varid).modal('hide');
                    } else {
                        if(response.success==0)
                        {
                            $("#file-error").html(response.message.diagramimg_file);
                            $("#file-error").show();
                          
                        }
                        else{
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
                    }
                  
                },

            });
        } else {
            // swal.fire({
            //     text: "Please Select File To Upload",
            //     confirmButtonText: 'Close',
            //     confirmButtonClass: 'btn btn-sm btn-danger',
            //     width: '350px',
            //     height: '10px',
            //     icon: 'warning',
            // });
            $("#file-error").show();
            //$("#diagramimage" + varid).modal('hide');
            return false;
        }

    }
</script>
