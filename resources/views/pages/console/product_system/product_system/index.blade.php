@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Product System </li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Product Systems</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
    <?php
        if($proccess_simulation_count>=2)
        {
        ?>    
        <a href="{{url('/product_system/product/create')}}" class="step-1 btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>&nbsp;
            Create New Product System
        </a>
    <?php
        }
        else
        {
    ?>
        <a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" onclick="alertconfirmation('You are not allowed to create product system, please create more than 1 process simulation first.','warning','/mfg_process/simulation/create')">
            <i class="fas fa-plus"></i>
            Create New Product System
        </a>
    <?php
        }
    ?>
        <p>
            <a href="#" id="tour" >Start it now!</a>
        </p>
        <div class="deletebulk">
            <button type="button" data-url="{{url('/product_system/product/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash"></i>&nbsp;
                Delete
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="product_sys_tbl" class="table table-hover mb-0 step-2">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Number of Processes</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($data)
                            @endphp
                            @if(!empty($data))
                            @foreach($data as $key=> $product_system)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($product_system['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$product_system['name']}}</td>
                                <td> {{$product_system['description']}} </td>
                                <td> {{$product_system['count']}} </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/product_system/product/'.___encrypt($product_system['id']).'?status='.$product_system['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($product_system['id'])}}" @if($product_system['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($product_system['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ url('/product_system/product/'.___encrypt($product_system['id']).'/manage')}}" type="button" class="btn btn-icon step-4" data-toggle="tooltip" data-placement="bottom" title="Product System Profile Settings">
                                            <i class="fas fa-cogs text-secondary"></i>
                                        </a>
                                        <a href="{{url('/product_system/product/'.___encrypt($product_system['id']).'/edit')}}" class="btn btn-icon step-3" data-toggle="tooltip" data-placement="bottom" title="Edit Product System">
                                            <i class="fas fa-edit text-secondary"></i> </a>
                                        <a href="javascript:void(0);" data-url="{{url('/product_system/product/'.___encrypt($product_system['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Product System">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <ul id="my-tour-steps">
        <li data-id=".step-4" data-position="none">
            <h1>Welcome to Mytour</h1>
            <p>
                Mytour is a simple but powerful jQuery plugin that allows you to improve the experiece
                visitors or users have when surfing on your sites or using your web apps.
            </p>
            <p>I hope you enjoy.</p>
        </li>
        <li data-id=".step-1" data-position="right">
            <h1>Step 1</h1>
            <p>Create New Product System Click Here.</p>
        </li>
        <li data-id=".step-2" data-position="top">
            <h1>Step 2</h1>
            <p>Product System List here. you can do sorting on click Particular Name.</p>
        </li>
        <li data-id=".step-3" data-position="top">
            <h1>Step 3</h1>
            <p>How about you try to use the dropdown menu ans go thru the steps?</p>
        </li>
        <li data-id=".step-4">
            <h1>Step 4</h1>
            <p>You can set any sequency of tour's tooltips. Now we're showing you the page's title.</p>
        </li>
        <li data-id=".step-5" data-position="top">
            <h1>Step 5</h1>
            <p>At least we can show you the last step and you can finish it or restart it. Make your self at home and enjoy it.</p>
        </li>
    </ul>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>

@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if (cnt > 10) {
        $('#product_sys_tbl').DataTable({
            "iDisplayLength": 100,
        });
    }

    $('.deletebulk').hide();

    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        $('.checkSingle').not(this).prop('checked', this.checked);
        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#example-select-all').prop('checked', true);
            } else {
                $('#example-select-all').prop('checked', false);
            }
        });
    });
    $('.checkSingle').click(function() {
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });

    function deleteSwal(titleMsg) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure Want To ' + titleMsg + ' ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes, ' + titleMsg + ' it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (titleMsg != "edit") {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been ' + titleMsg + '.',
                        'success'
                    )
                } else {
                    window.location = '/product_system/product/1/edit';
                }
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled'
                )
            }
        })
    }
</script>
@endpush