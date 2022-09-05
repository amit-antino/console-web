@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.___encrypt($tenant->id))}}">{{$tenant->organization_name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Menu Group</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/'.___encrypt($tenant->id).'/role')}}" role="roles" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Menu Group</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name">Menu Group Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Menu Group Name"></i></span>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="Menu Group Name" required>
                        </div>
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="role_access_level">Select Menu Group Access Level
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Menu Group Access Level"></i></span>
                                    </label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" id="select-all" class="form-check-input">
                                                Check All
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div id="treeview-checkbox-demo">
                                        <ul>
                                            @if(!empty($submenu))
                                            @foreach($submenu as $sk =>$sv)
                                            <li class="form-check-input" data-value="{{$sv['menu_id']}}"> &nbsp;{{$sv['menu']}}
                                                @if(!empty($sv['submenu']))
                                                <ul>
                                                    @foreach($sv['submenu'] as $subk=>$subv)
                                                    <li class="form-check-input" data-value="{{$subv['id']}}"> &nbsp;{{$subv['name']}}</li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description / Note
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description / Note"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="roles"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="/admin/tenant" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="https://www.jquery-az.com/jquery/js/jquery-treeview/logger.js"></script>
<script src="https://www.jquery-az.com/jquery/js/jquery-treeview/treeview.js"></script>

<script>
    $('#treeview-checkbox-demo').treeview({
        debug: true,
        data: ['links', 'Do WHile loop']
    });
    $('.tw-control').attr('name', 'menu_list[]');
    $("#select-all").click(function() {
        $('.tw-control').trigger('click');
        $('.tw-control').not(this).prop('checked', this.checked);

        trigger();
    });
    $('.tw-control').click(function() {
        if ($('.tw-control:checked').length == $('.tw-control').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });
    $('#show-values').on('click', function() {
        $('#values').text(
            $('#treeview-checkbox-demo').treeview('selectedValues')
        );
    });
</script>
<script>
    // $(function() {

    //     // Multi Select
    //     if ($(".js-example-basic-single").length) {
    //         $(".js-example-basic-single").select2();
    //     }
    //     $("#select-all").click(function() {
    //         $('.checkSingle').not(this).prop('checked', this.checked);
    //     });

    //     $('.checkSingle').click(function() {
    //         if ($('.checkSingle:checked').length == $('.checkSingle').length) {
    //             $('#select-all').prop('checked', true);
    //         } else {
    //             $('#select-all').prop('checked', false);
    //         }
    //     });
    // });
    // $(document).on('click', '.select-sub', function() {
    //     $('.checkSub' + this.id).not(this).prop('checked', this.checked);

    // });
</script>
@endpush