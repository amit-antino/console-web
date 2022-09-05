<ul id="list-example1" class="nav nav-tabs nav-tabs-line" id=" myTab" role="tablist">
    <li class=" nav-item">
        <a class="nav-link show active" id="associated_models_tab" data-toggle="tab" href="#associated_models" role="tab" aria-controls="associated_models" aria-selected="true" onclick="getmodelList()">Associated Models</a>
    </li>
</ul>
<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="associated_models" role="tabpanel" aria-labelledby="associated_models-tab">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin float-right">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @php
                $per = request()->get('sub_menu_permission');
                $permission=!empty($per['model']['method'])?$per['model']['method']:[];
                @endphp
                @if($viewflag!="view")
                <button type="button" style="position:absolute;right:0px;top:50px"  class="btn btn-sm btn-secondary btn-icon-text mr-0 d-none d-md-block" 
                {{-- @if(in_array('create',$permission)) --}}
                    onclick="getmodel()"
                {{-- @else
                    data-request="ajax-permission-denied"
                @endif --}}
                >
                    <i class="fas fa-plus"></i>&nbsp;&nbsp; Request New Model
                </button>
                {{-- <button type="button" style="position:absolute;right:170px;top:50px" class="btn btn-sm btn-secondary btn-icon-text mr-0  d-none d-md-block" onclick="requestModel()">
                    <i class="fas fa-tasks"></i>&nbsp;&nbsp; Request a new model
                </button> --}}
                <div class="deletebulk_model" style="position:absolute;right:348px;top:50px;display: none;">
                    <button type="button" onclick="bulkdelModeldetail()" class="btn btn-sm btn-danger btn-icon-text mt-0 mr-0 d-none d-md-block"
                    @if(in_array('delete',$permission))
                        onclick="bulkdelModeldetail()" 
                    @else
                        data-request="ajax-permission-denied"
                    @endif
                    >
                        <i class="fas fa-trash"></i>&nbsp;&nbsp; Delete
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="mb-3 grid-margin" id="render_list_models">
        </div>
    </div>
</div>
<div class="" id="render_upload_models">
</div>
<div class="" id="render_edit_models">
</div>
<script>
    getmodelList();

    function getmodelList() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/associate_model') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                vartion_id: vartion_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#render_list_models').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getmodel() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/upload_associate_model') }}",
            method: 'post',
            data: {
                process_experiment_id: process_experiment_id,
            },
            success: function(result) {
                $('#render_upload_models').html(result.html);
                $("#savemodel").modal('show');
                $('#expprofileSpinner').hide();
            }
        });

    }

    function editmodelView() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/render_edit_models')}}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                vartion_id: vartion_id
            },
            success: function(result) {
                $('#render_edit_models').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }
</script>