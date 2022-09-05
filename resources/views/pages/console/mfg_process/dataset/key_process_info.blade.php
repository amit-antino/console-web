<link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/plugins/simplemde/simplemde.min.js') }}"></script>
<!-- <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script> -->
<link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
<style>
    .wizard>.content {
        background: #eee;
        display: block;
        margin: 0.5em;
        min-height: 25em;
        overflow: hidden;
        position: relative;
        width: auto;
        border-radius: 5px;
        min-height: 28rem;
        overflow: auto;
        background: #ffffff;
        border: 1px solid #e8ebf1;
        margin-left: 0;
        padding: 1em 1em;
    }
</style>
<script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
<div class="" id="keypro" role="tabpanel" aria-labelledby="key_proces_tab">
    <div class="card shadow">
        <form method="post" id="profileE1masskey" action="javascript:void(0)" enctype="multipart/form-data">
            @CSRF
            <div class="card-body">
                <div class="form-row">
                <input type="hidden" id="dataset_id" name="dataset_id" class="form-control" value="{{___encrypt($process_dataset['id'])}}">
                    <div class="form-group col-md-12">
                        <label class="control-label text-muted">Notes / Files
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Source File"></i></span>
                        </label>
                        <input type="file" class="form-control-file" id="e1_source_file" name="e1_source_file[]" placeholder="Select Source File" accept="image/png, image/gif, image/jpeg, application/pdf" multiple>
                        <br>
                        @if(!empty($process_dataset['key_process_info']['image']))  
                        <label class="control-label text-muted">Uploaded files - <br>
                            @foreach($process_dataset['key_process_info']['image'] as $icnt=>$img)
                            @if($viewflag!='view_config')
                            <a href="javascript:void(0);" class="btn btn-icon" style='margin-top:7px' onclick="deleteimg('{{$icnt}}')" data-toggle="tooltip" data-placement="bottom" title="Delete Dataset">
                                <i class="fas fa-trash text-secondary"></i>
                            </a>    
                            @endif
                            {{ltrim($img,'assets/uploads/key_process_info/')}} <br>
                            @endforeach                                         
                        </label>
                        @endif
                    </div>
                    <div class="form-group col-md-8"></div>
                    <div class="form-group col-md-12">
                        <label class="control-label text-muted">News / Literature
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="News / Literature"></i></span>
                        </label>
                        <textarea class="form-control " name="tinymceExample" id="tinymceExample" rows="5">
                            @if(!empty($process_dataset['key_process_info']))                                              
                            {{$process_dataset['key_process_info']['newsliterature']}}
                            @endif
                        </textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label text-muted">Regulatory Information
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Regulatory Information"></i></span>
                        </label>
                        <textarea class="form-control" name="tinymceExample1" id="tinymceExample1" rows="5">
                            @if(!empty($process_dataset['key_process_info']))                                              
                            {{$process_dataset['key_process_info']['regulatoryinformatio']}}
                            @endif
                        </textarea>
                    </div>
                </div>
            </div>
            @if($viewflag!='view_config')
            <div class="card-footer text-right">
                <button type="button" onclick="keyInfo()" class="btn btn-sm btn-secondary submit">Submit</button>
                <a href="{{ url('/mfg_process/simulation') }}" class="btn btn-sm btn-danger">Cancel</a>
            </div>
            @endif
        </form>
    </div>
</div>

<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/js/test.js')}}"></script>
<script src="{{ asset('assets/js/tinymce.js') }}"></script>
<script>
    var viewflag = '{{$viewflag}}'
    if(viewflag=='view_config'){
        $("input").prop("disabled", true);
        $("textarea").prop("disabled", true);
    }

    function keyInfo() {
        var url = "{{URL('/mfg_process/simulation/dataset/key_process_info')}}";
        var formData = new FormData();
        var data = tinyMCE.get('tinymceExample').getContent();
        var data1 = tinyMCE.get('tinymceExample1').getContent();
        var files = document.getElementById("e1_source_file").files;
        for(i=0;i<files.length;i++){
            // fileName.split('.').pop();
            formData.append('file[]', files[i]);
        }
        // formData.append('file', files[0]);
        formData.append('newsliterature', data);
        formData.append('regulatoryinformatio', data1);
        dataset_id = document.getElementById('dataset_id').value;
        formData.append('dataset_id', dataset_id);
        formData.append('keyinfo', 'keyinfo');
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.success === true) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    })
                    $('#key_process_info').trigger('click')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.errors,
                    })
                }
            }
        })
    }

    function deleteimg(id) {
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
                dataset_id = document.getElementById('dataset_id').value;
                $.ajax({
                    url: "{{ url('/mfg_process/simulation/dataset/delete_keyprocessinfo_img') }}",
                    method: 'post',
                    data: {
                        id: id,
                        dataset_id : dataset_id,
                    },
                    success: function(result) {
                        debugger;
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Key process image deleted successfuly',
                        })
                        $('#key_process_info').trigger('click')
                        $('#expprofileSpinner').hide();
                    }
                });
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    '',
                    'error'
                )
                $('#key_process_info').trigger('click')
                $('#expprofileSpinner').hide();
            }
        })
    }
</script>
