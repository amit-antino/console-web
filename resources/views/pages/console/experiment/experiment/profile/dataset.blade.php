<ul id="list-example1" class="nav nav-tabs nav-tabs-line" id=" myTab" role="tablist">
    <li class=" nav-item">
        <a class="nav-link show active" id="dataset_list_tab" data-toggle="tab" href="#dataset_list" role="tab" aria-controls="dataset_list" aria-selected="true" onclick="getdatasetList()">Dataset List</a>
    </li>

</ul>
<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="dataset_list" role="tabpanel" aria-labelledby="dataset_list-tab">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin float-right">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                @php
                $per = request()->get('sub_menu_permission');
                $permission = !empty($per['dataset']['method']) ? $per['dataset']['method'] : [];
                @endphp
                @if ($viewflag != 'view')
                <button type="button" style="position:absolute;right:0px;top:50px" class="btn btn-sm btn-secondary btn-icon-text mr-0" {{-- @if (in_array('create', $permission)) --}} onclick="getdatasetmodel()" {{-- @else
                        data-request="ajax-permission-denied"
                @endif --}}>
                    <i class="fas fa-plus"></i>&nbsp;&nbsp; Upload New Dataset
                </button>

                <a style="position:absolute;right:180px;top:50px" href="{{ asset('assets/sample/Sample_template_for_download.xlsx') }}" class="btn btn-sm btn-secondary btn-icon-text mr-0"> <i class="fas fa-download"></i>&nbsp;&nbsp;
                    Template</a>
                &nbsp;&nbsp;
                <div class="deletebulk_dataset" style="display: none;">
                    <button type="button" class="btn btn-sm btn-danger btn-icon-text mt-0 mr-0 d-none d-md-block" @if (in_array('delete', $permission)) onclick="bulkdelDataset()" @else data-request="ajax-permission-denied" @endif>
                        <i class="fas fa-trash"></i>&nbsp;&nbsp; Delete
                    </button>
                </div>
                @endif
            </div>

        </div>
        <div class="mb-3 grid-margin" id="render_list_dataset">
        </div>
    </div>
</div>
<div class="mb-3 grid-margin" id="render_dataset_models1">
</div>
<div class="mb-3 grid-margin" id="render_edit_dataset">
</div>

<script>
    getdatasetList();
    //updateDatasetModel
    function getdatasetList() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/dataset_list') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                vartion_id: vartion_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#render_list_dataset').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getdatasetmodel() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/upload_dataset_model') }}",
            method: 'post',
            data: {
                process_experiment_id: process_experiment_id,
            },
            success: function(result) {
                $('#render_dataset_models1').html(result.html);
                $("#savedataset").modal('show');
                $('#expprofileSpinner').hide();
            }
        });
    }
</script>