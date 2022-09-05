@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/'.$tenant_id.'/designation')}}">Designation</a></li>
        <li class="breadcrumb-item active">Edit Designation</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="javascript:void(0)" enctype="multipart/form-data" id="dept">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Designation</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Designation Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Designation Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control" Value="{{$designation['name']}}" >
                            <input type="hidden" id="status" name="status" class="form-control" value="{{$designation['status']}}" >
                        </div>
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description">{{$designation['description']}}</textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="tags">Tags
                                <i data-toggle="tooltip" title="Enter tags. You can enter maximum 16 values comma seperated" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" value="{{$designation['tags']}}" class="form-control" id="tags" name="tags" style="height:100%;"/>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submitEdit" class="btn btn-sm btn-secondary submit">Submit</button>
                    <a href="{{url('/admin/tenant/'.$tenant_id.'/designation')}}" class="btn btn-danger btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#tags').tagsInput({
            'height': '75%',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
            'placeholderColor': '#666666'
        });
    });
    $('#submitEdit').on('click', function(event) {
        var url = "{{url('/admin/tenant/'.$tenant_id.'/designation/'.___encrypt($designation['id']))}}";
        var name = $("#name").val();
        var description = $("#description").val();
        var tags = $("#tags").val();
        var objectexp = {
            "name": name,
            "description": description,
            "tags":tags
        };
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'PUT',
            url: url,
            data: JSON.stringify(objectexp),
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success === true) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 30000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    })
                    window.location = "{{url('/admin/tenant/'.$tenant_id.'/designation')}}";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.errors,
                    })
                }
            },
        });
    });
</script>
@endpush