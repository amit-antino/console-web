<div class="modal fade bd-example-modal-lg" id="editdataset{{___encrypt($dataset['id'])}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Model Update </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="model_type">Select Dataset
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Data Type"></i></span>
                            </label>

                            <input type="text" value="{{$dataset->name}}" class="form-control" id="dataset_name" name="dataset_name" required placeholder="Enter Dataset name">
                            <input type="hidden" value="{{___encrypt($dataset->id)}}" class="form-control" id="simulation_input_id" name="simulation_input_id" required placeholder="Enter Dataset name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model_type">Select Model
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Data Type"></i></span>
                            </label>
                            <select data-width="100%" class="form-control" id="model_type" name="model_type" required>
                                <option value="0">Select Model</option>
                                @if(!empty($datamodel))
                                @foreach($datamodel as $dm =>$dmv)
                                <option value="{{$dmv->id}}">{{$dmv->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Model update notes
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                            </label>
                            <textarea name="update_notes" id="update_notes" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="udate_parameter">Update parameters
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Notes"></i></span>
                            </label>
                            <textarea name="udate_parameter" id="udate_parameter" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" onclick="saveDatasetModel()" class="btn btn-sm btn-secondary ">Request Model update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function saveDatasetModel() {
        var fd = new FormData();
        var simulation_input_id = $('#simulation_input_id').val();
        var dataset_name = $('#dataset_name').val();
        var model_type = $('#model_type').val();
        var update_notes = $('#update_notes').val();
        var udate_parameter = $('#udate_parameter').val();
        var description = $('#description').val();
        fd.append('simulation_input_id', simulation_input_id);
        fd.append('dataset_name', dataset_name);
        fd.append('model_type', model_type);
        fd.append('update_notes', update_notes);
        fd.append('udate_parameter', udate_parameter);
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/exp_dataset_update') }}",
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#editdataset" + simulation_input_id).modal('hide');
                if (response.success == true) {
                    $('#dataset_list_tab').trigger('click')
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timer: 5000,
                    });
                    Toast.fire({
                        icon: 'success',
                        title: "Dataset Model Updated",
                    })

                } else {
                    alert('file not uploaded');
                }
            },
        });

    }
</script>