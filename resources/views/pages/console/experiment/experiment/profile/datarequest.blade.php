<ul id="list-example1" class="nav nav-tabs nav-tabs-line" id=" myTab" role="tablist">
    <li class=" nav-item">
        <a class="nav-link show active" id="datarequest_list_tab" data-toggle="tab" href="#datarequest_list" role="tab" aria-controls="datarequest_list" aria-selected="true" onclick="getdatareqList()">Data/Model request status</a>
    </li>

</ul>
<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="datarequest_list" role="tabpanel" aria-labelledby="datarequest_list_tab">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin float-right">
            <div class="d-flex align-items-center flex-wrap text-nowrap">
            @php
                $per = request()->get('sub_menu_permission');
                $permission=!empty($per['data_request']['method'])?$per['data_request']['method']:[];
            @endphp
                @if($viewflag!="view")
                <button type="button" style="position:absolute;right:0px;top:50px" class="btn btn-sm btn-secondary btn-icon-text mr-0" 
                    {{-- @if(in_array('create',$permission)) --}}
                        onclick="getdatasereqtmodel()"
                    {{-- @else
                        data-request="ajax-permission-denied"
                    @endif --}}
                >
                    <i class="fas fa-plus"></i>&nbsp;&nbsp; Request Model Update
                </button>

                <div class="deletebulk_data_request" style="display:none;position:absolute;right:200px;top:50px">
                    <button type="button"  class="btn btn-sm btn-danger btn-icon-text mt-0 mr-0"
                    @if(in_array('delete',$permission))
                        onclick="bulkdelDataRequest()"
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
        <div class="mb-3 grid-margin" id="render_list_datareq">
        </div>
    </div>
  
</div>
</div>
</div>
</div>
<div class="" id="render_datareq_models1">
</div>
<script>
    $(function() {
        if ($('#datarequest_tab').hasClass('reqtab')) {
            $("#upload_datasetreq_tab").trigger("click");
        }
    });


    getdatareqList();

    function getdatareqList() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/datareq_list') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                vartion_id: vartion_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#render_list_datareq').html(result.html);
                $('#expprofileSpinner').hide();

            }
        });
    }

    function getdatasereqtmodel() {

        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/upload_datareq_model') }}",
            method: 'post',
            data: {
                process_experiment_id: process_experiment_id,
            },
            success: function(result) {
                $('#render_datareq_models1').html(result.html);
                $("#savedatarequest").modal('show');
                $('#expprofileSpinner').hide();

            }
        });
    }
</script>