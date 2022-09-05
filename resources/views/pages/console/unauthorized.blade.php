@extends('layout.console.master-error')
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <img src="{{ url('assets/images/404.svg') }}" class="img-fluid mb-2" alt="404">
            <h1 class="font-weight-bold mb-22 mt-2 tx-80 text-muted">Permission Denied</h1>
            <h4 class="mb-2">Contact With Adminstrator</h4>
            <h6 class="text-muted mb-3 text-center">Oopps!! The page you were looking for doesn't exist. Please Contact Admin</h6>
            <a href="{{$previous_url}}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
@push('custom-scripts')
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        swal.fire({
            html: 'Permission Denied',
            showLoaderOnConfirm: false,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            icon: "warning",
            customClass: "success-popup-custom-class",
            confirmButtonText: "Ok",
        }).then(
            function(isConfirm) {
                if (isConfirm) {
                    setTimeout(function() {
                        window.location.href = "{{$previous_url}}";
                    }, 10);

                }
            },
            function(dismiss) {}
        ).catch(swal.noop);
    });
</script>
@endpush